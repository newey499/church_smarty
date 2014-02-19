<?php

/*****************************

Class calendar

Creates a table combining rows 
from forthcomingevents and regularevents tables
for a given month and year.

CDN 		27/02/2010  Fix to ensure class honours isvisible flag setting on 
										regular and forthcoming tables when loading
										a months events into the temporary calendar table.
CDN     19/02/2014  Rewrite to use as a Model for Smarty template engine website 
										loosely modelled on MVC concept.
*************************************/

require_once('php/class.MysqliExtended.php');

Class CalendarDay
{	
	public $date_str;
	public $date_unix;
	
	public $month_str;
	public $month_int;
	public $day_in_requested_month = true;
	
	public $aEvents = [];
	
	function __construct(DateTime $oStartOfMonth, DateTime $oDate) 
	{
		$oMysql = MysqliExtended::getInstance();
		$oStatement = $oMysql->stmt_init();
		
		$this->date_str = $oDate->format("Y-m-d");
		$this->date_unix = $oDate->getTimestamp();
		
		$this->day_in_requested_month = ($oStartOfMonth->format("m") == $oDate->format("m"));
		
		$this->month_str = $oStartOfMonth->format("m");
		$this->month_int = intval($this->month_str);
		
		$qry = " SELECT " . Calendar::SELECT_COLUMNS . 
					 " , (eventtime <> '11:11:00') AS displaytime " .
					 " FROM calendar " .
					 " WHERE eventdate = ? and isvisible = 'YES' " .
					 " ORDER BY eventtime";
		
		$this->aEvents = [];
		
		if(!$oStatement->prepare($qry))
		{
				die("Failed to prepare statement query [$qry]");
		}
		else
		{
				$oStatement->bind_param("s", $this->date_str);

				$oStatement->execute();
				$result = $oStatement->get_result();
				while ($row = $result->fetch_assoc())
				{
					$this->aEvents [] = $row;
				}

		}

		$oStatement->close();
		
	}
	
	function __destruct()
	{
	
	}
	
};

Class CalendarWeek
{
	public $week;
	public $aDays = []; // Array of CalendarDay objects
	
	function __construct($week, DateTime $oDate)
	{
		$this->week = $week;
	}
	
	function __destruct()
	{
		
	}
	
};


Class Calendar
{
	const SELECT_COLUMNS = ' id, parentid, eventsource, eventdate, eventtime, eventname, linkurl, isvisible ';	
	
	/******************
	 Properties
	*********************/
	public $month;
	public $year;
	public $startOfMonth = "start of month not set";
	public $startOfMonthDayOfWeek_int = -1;
	public $startOfMonthDayOfWeek_str = "start of month day not set";	
	public $startOfCalendarDayOfWeek_int = -1;
	public $startOfCalendarDayOfWeek_str = "start of Calendar day not set";	
	public $endOfCalendarDayOfWeek_int = -1;
	public $endOfCalendarDayOfWeek_str = "end of Calendar day not set";	
	
	public $row_count = 0;
	public $aWeeks = []; // Array of CalendarWeek objects
	
	protected $day;
	
	//protected $createCalendarTableInMemory = TRUE;   // Use a temporary table for live use
	protected $createCalendarTableInMemory = FALSE;  // development switch to leave the temporary table in existence during testing

	protected $oMysql = NULL;
	
	function __construct($month, $year) 
	{
		$this->name  = "CalendarClass";
		$this->day   = 1;
		$this->month = intval($month);
		$this->year  = intval($year);

		$this->startOfMonth = sprintf('%d-%02d-01 00:00:00', $this->year, $this->month);
		
		$this->oMysql = MysqliExtended::getInstance();

		/********
			CDN 12/12/11
			Load the forthcoming events first. A Regular Event with the same event date and time
			as a forthcoming event date and time is ignored. This ensures that Xmas and Easter services
			override regular services causing the rgular sevices not to be displayed.
		*****************/
		$this->createTable();
		$this->loadForthcomingevents();	
		$this->loadRegularevents();
			
		// ================================================================
		// Load the Calendar events into a format Smarty can handle easily.
		// Calendar
		//		Array of Calendar week objects
		//			Array of Calendar day objects
		//				Array of Calendar Event Objects
		// =================================================================
		$this->loadTableIntoClass();
		
	}

	function __destruct() 
	{
		if ($this->createCalendarTableInMemory)
		{
			$this->dropTable();
		}
	}


	/******************
	 Methods
	*********************/

	protected function createTable() 
	{
		$this->dropTable();

		if ($this->createCalendarTableInMemory)
		{
			$qry  =  "CREATE TEMPORARY TABLE calendar ";
		}
		else
		{
			$qry  =  "CREATE TABLE calendar ";
		}
		
		$qry .= "( ";
		$qry .= "  id integer NOT NULL auto_increment primary key, ";
		$qry .= "  parentid integer NOT NULL, ";
		$qry .= "	 eventsource enum('FORTHCOMING', 'REGULAR') NOT NULL, ";
		$qry .= "  eventdate date not null, ";
		$qry .= "  eventtime time NOT NULL COMMENT 'Timeof 11:11 (php global FC_HIDE_TIME) is flag for do not display time',  ";
		$qry .= "  eventname varchar(250) NOT NULL, ";
		$qry .= "  linkurl varchar(250), ";
		$qry .= "  isvisible enum('YES', 'NO') DEFAULT 'YES' ";		
		
		// Always use the memory engine - its quicker and it still stores the table
		// in the schema as long as the "TEMPORARY" clause is not used.
		$qry .= ") ENGINE=MEMORY; ";
		/******************************************
		if ($this->createCalendarTableInMemory)
		{
			$qry .= ") ENGINE=MEMORY; ";
		}
		else 
		{
			$qry .= ") ENGINE=MyISAM; ";			
		}
		*********************************************/

		if ($this->oMysql->query($qry) == FALSE)
		{
			die("Failed to create temporary calendar table");
		}

	}

	protected function dropTable()
	{
		if ($this->oMysql->query('DROP TABLE IF EXISTS calendar') == FALSE)
		{
			die("Failed to drop calendar table");
		}
	}


	protected function loadForthcomingevents()
	{
		/*************
		02/08/2010	CDN		Get following month as well so as to display events at start of 
											following month instead of leaving blank
		************************/
		$qry  = "INSERT INTO calendar ";
		$qry .= " (parentid, eventsource, eventdate, eventtime, eventname, linkurl, isvisible ) ";
		$qry .= "SELECT id, 'FORTHCOMING', eventdate, eventdate as eventtime, eventname, linkurl, isvisible ";
		$qry .= "FROM forthcomingevents ";
		$qry .= "WHERE ( ";
		$qry .= "        month(eventdate) = " . $this->month ;
		$qry .= "        OR "; 
		$qry .= "        month(eventdate) + 1 = " . $this->month + 1;		
		$qry .= "      )";
		$qry .= "      AND isvisible = 'YES' ";

		if ($this->oMysql->query($qry) == FALSE)
		{
			print($this->oMysql->error);
			die("Failed to Import rows from forthcomingevents");
		}

	}

	protected function loadRegularevents()
	{
		$date = new DateTime();
		$endDate = new DateTime();

		$this->day   = '1';

		// 15/12/2011 CDN Pick up first seven days of next month
		//$endDate->setDate($this->year, $this->month + 1, $this->day);
		$endDate->setDate($this->year, $this->month + 1, 7);

		$date->setDate($this->year, $this->month, 1);
		$date->modify("-7 day");  // pick up last seven days of previous month

		while ( $this->processDate($date, $endDate)  )
		{
			for ($dow= 1; $dow <= 7; $dow++)
			{
				$this->getRegularEvent($date);
				$date->modify("+1 day");
			}
		}


	}


	// $oDate - must be a datetime object
	protected function getRegularEvent($oDate)
	{
		$str = "";
		$dow = strtoupper($oDate->format("l")); // MONDAY, TUESDAY etc
		$wom = $this->weekOfMonth($oDate);  // Week of month - 1,2 etc
		$oNullDate = new dateTime('0000-00-00');
		$mySqlDate = $oDate->format("Y-m-d");					// YYYY-MM-DD

		$qry = "SELECT id, dayofweek, weekofmonth, startdate, enddate, eventtime, eventname," . 
		       "       eventdesc, isvisible, linkurl " . 
	         " , DATEDIFF(startdate, '" . $oDate->format("Y-m-d") . "') AS diffstart " . 
	         " , DATEDIFF(enddate, '" . $oDate->format("Y-m-d") . "') AS diffend " . 
		       "FROM regularevents " . 
		       "WHERE " . 
					 "  ( " . 
					 "    startdate <= '" . $oDate->format("Y-m-d") . "' " . 
					 "  ) " .
					 "  AND " . 
					 "  ( " . 
					 "  	(enddate IS NULL) " . 
					 "  	OR (enddate IS NOT NULL AND " . 
					 "       ( enddate = '0000-00-00' OR '" . $oDate->format("Y-m-d") . "'  < enddate ) ) " . 
					 "  ) " . 
					 "  AND " .
					 "  ( " .
	         "    ( dayofweek = 'ALL' OR dayofweek = '" . $dow . "' ) " . 
					 "    AND " . 
					 "    ( weekofmonth = 'ALL' OR weekofmonth = 'WEEK" . $wom . "' ) " . 
					 "  ) " . 
					 "  AND " .
					 "  ( " .	
					 "    isvisible = 'YES' " . 				 
					 "  ) " . 					 
		       "ORDER BY eventtime";  

		$res = $this->oMysql->query($qry);
		
		if (! $res)
		{
			print($this->oMysql->error);
			die("Failed to Import rows from regularevents");
		}

		while ( $row = $res->fetch_assoc() ) 
		{
			// 12/12/11		CDN   A Regular Event with the same event date and time
			// 									as a forthcoming event is ignored. This ensures that Xmas and Easter services
			// 									override regular services causing the regular sevices not to be displayed.

			$qryForthcomingExists = sprintf("SELECT * FROM forthcomingevents " .
			  															" WHERE date(eventdate) = '%s' " .
    																	"       AND time(eventdate) = '%s' ",
																			date_format($oDate, "Y-m-d"),
																			$row['eventtime']											
																		 );

			$resForthCheck = $this->oMysql->query($qryForthcomingExists);

			if ($resForthCheck->num_rows == 0)
			{

				$qry  = "INSERT INTO calendar ";
				$qry .= " (parentid, eventsource, eventdate, eventtime, eventname, linkurl, isvisible) ";
				$qry .= "VALUES ";
				$qry .= " ( ";
				$qry .= " " . $row['id'] . ", ";
				$qry .= " 'REGULAR', ";
				$qry .= "'" . date_format($oDate, "Y-m-d") . "', ";
				$qry .= "'" . $row['eventtime'] . "', ";
				$qry .= "'" . $row['eventname'] . "', ";
				$qry .= "'" . $row['linkurl'] . "', ";
				$qry .= "'" . $row['isvisible'] . "' ";			
				$qry .= " ) ";

				if (! $this->oMysql->query($qry))
				{
					die("Insert of REGULAR event on calendar table failed");
				}
				
				$resForthCheck->free_result();				

			}

		}

		$res->free_result();

		return $str;

	}


	// $oDate - must be a datetime object
	protected function weekOfMonth($oDate)
	{
		$weekNo = ($oDate->format("d") / 7);
		$week = 0;

	  if ($weekNo <= 1)
			$week = 1;
		else if ($weekNo <= 2)
			$week = 2;
		else if ($weekNo <= 3)
			$week = 3;
		else if ($weekNo <= 4)
			$week = 4;
		else if ($weekNo <= 5)
			$week = 5;
		else if ($weekNo > 5)  // No months with more than 5 weeks
			die("Impossible Week Number [" . $weekNo .
          "] based on date [" . $oDate->format("Y-m-d") . "]");

		return $week;
	}

	/**********************
	Expects two DateTime objects - returns true if $oDateCurrent <= $oDateEnd else returns false
	******************************/
	protected function processDate($oDateCurrent, $oDateEnd)
	{
		$result = true;

		$current = date_format($oDateCurrent, 'Ymd');
		$end = date_format($oDateEnd, 'Ymd');

		$intResult = strcmp($current, $end);
		$result = ( $intResult <= 0 );

		//print("diff [" . $intResult . "]<br />\n");

		return $result;
	}	
	
	
	// ================================================================
	// Load the Calendar events into a format Smarty can handle easily.
	// Calendar
	//		Array of Calendar week objects
	//			Array of Calendar day objects
	//				Array of Calendar Event Objects
	// =================================================================
	protected function loadTableIntoClass()
	{
		$oDate = new DateTime($this->startOfMonth);
		$this->startOfMonth = $oDate->format("Y-m-d 00:00:00");
		$aDateInfo = getdate($oDate->getTimestamp());

		$this->startOfMonthDayOfWeek_int = $aDateInfo['wday'];
		$this->startOfMonthDayOfWeek_str = $aDateInfo['weekday'];		

		$oDateCalStart = clone $oDate;
		$aDateInfo = getdate($oDateCalStart->getTimestamp());		
		$this->startOfCalendarDayOfWeek_int = $aDateInfo['wday'];
		$this->startOfCalendarDayOfWeek_str = $aDateInfo['weekday'];			
		$interval = DateInterval::createFromDateString(sprintf("%d day", ($this->startOfCalendarDayOfWeek_int - 1)));
		$oDateCalStart->sub($interval);
		$aDateInfo = getdate($oDateCalStart->getTimestamp());		
		$this->startOfCalendarDayOfWeek_int = $aDateInfo['wday'];
		$this->startOfCalendarDayOfWeek_str = $aDateInfo['weekday'];	
		
		$oDateCalEnd = clone $oDateCalStart;
		$interval = DateInterval::createFromDateString('1 month');
		$oDateCalEnd->add($interval);					
		$aDateInfo = getdate($oDateCalEnd->getTimestamp());		
		$this->endOfCalendarDayOfWeek_int = $aDateInfo['wday'];
		$this->endOfCalendarDayOfWeek_str = $aDateInfo['weekday'];			
		$interval = DateInterval::createFromDateString(sprintf("%d day", (7 - $this->endOfCalendarDayOfWeek_int)));
		$oDateCalEnd->add($interval);
		$aDateInfo = getdate($oDateCalEnd->getTimestamp());		
		$this->endOfCalendarDayOfWeek_int = $aDateInfo['wday'];
		$this->endOfCalendarDayOfWeek_str = $aDateInfo['weekday'];			
		
		$qry = ' SELECT ' . Calendar::SELECT_COLUMNS .
					 ' FROM calendar ' . 
					 ' ORDER BY eventdate, eventtime';
		$oRes = false;
		if (! $oRes = $this->oMysql->query($qry))
		{
			die("SELECT from calendar table failed: [" . $this->oMysql->error . "] qry [$qry]");
		}		
		
		$oCurrentDate = clone $oDateCalStart;
		$oAddOneDay = DateInterval::createFromDateString("1 day");
		
		$i = 1;
		$oCalendarWeek = NULL;
		while ($this->processDate($oCurrentDate, $oDateCalEnd))
		{
			
			$oCalendarWeek = new CalendarWeek("week " . sprintf("%d", $i++), $oCurrentDate);
			$this->aWeeks [] = $oCalendarWeek;
				
			for ($j = 1; $j <= 7; $j++)
			{
				$oCalendarWeek->aDays [] = new CalendarDay(new DateTime($this->startOfMonth), $oCurrentDate);
				$oCurrentDate->add($oAddOneDay);
			}
		
		}
		
		$oRes->free_result();
	}
		
}; // End Class Calendar
  // =========================================================================

?>
