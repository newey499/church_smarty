<?php

/*****************************

Class calendar

Creates a table combining rows 
from forthcomingevents and regularevents tables
for a given month and year.

Temporary table is deleted by destructor

Subclass this object and override the getEventStr
method to change the html the object spits back.

CDN 		27/02/2010  Fix to ensure class honours isvisible flag setting on regular and forthcoming tables when loading
										a months events into the temporary calendar table.
*************************************/

require_once('class.MysqliExtended.php');


Class Calendar
{
	/******************
	 Properties
	*********************/
	private $month;
	private $year;
	private $day;
	//private $useTempTable = TRUE;   // Use a temporary table for live use
	private $useTempTable = FALSE;  // development switch to leave the temporary table in existence during testing

	private $oMysql = NULL;
	
	function __construct($month, $year) 
	{
		$this->name  = "CalendarClass";
		$this->day   = 1;
		$this->month = intval($month);
		$this->year  = intval($year);

		$this->oMysql = MysqliExtended::getInstance();
		
		// print("<h1>month [$month] year [$year]</h1>");

		/********
			CDN 12/12/11
			Load the forthcoming events first. A Regular Event with the same event date and time
			as a forthcoming event date and time is ignored. This ensures that Xmas and Easter services
			override regular services causing the rgular sevices not to be displayed.
		*****************/
		$this->createTable();
		$this->loadForthcomingevents();	
		$this->loadRegularevents();
		//mysql_query("CALL buildCalendarTableRows('" . $year . "-" . $month . "-01')");


	}

	function __destruct() 
	{
		if ($this->useTempTable)
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

		if ($this->useTempTable)
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
		//$qry .= ") TYPE=HEAP; "; // CDN 20/4/12 - new version of MySQL doesn't support this syntax
		$qry .= ") ENGINE=MEMORY; ";

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
		//$qry .= "      AND year(eventdate) = " . $this->year;
		$qry .= "      AND isvisible = 'YES' ";


		if ($this->oMysql->query($qry) == FALSE)
		{
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

		//$date->setDate($this->year, $this->month, $this->day);
		$date->setDate($this->year, $this->month, 1);
		$date->modify("-7 day");  // pick up last seven days of previous month

		/********
		print("$count, this month[" . $this->month .
			  "] date month [" . date_format($date, 'm') . "] " . 
			  " termination date [" . date_format($endDate, 'Y-m-d') . "]<br />\n");
		*************/
		$count = 0;

		// while ( ( date_format($date, 'm') <= $this->month) || ( ($this->month + 1 ) == date_format($date, 'm'))  )
		while ( processDate($date, $endDate)  )
		{
			for ($dow= 1; $dow <= 7; $dow++)
			{
				$this->getRegularEvent($date);
				$date->modify("+1 day");

				/*******
				print("$count, this month[" . $this->month .
					  "] date month [" . date_format($date, 'm') .
					  "] <br />\n");
				**********/
				$count = $count + 1;



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
	         //" , DATEDIFF(startdate, '" . $mysqlToday . "') AS diffstart " . 
	         //" , DATEDIFF(enddate, '" . $mysqlToday . "') AS diffend " . 
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

		if ($res = $this->oMysql->query($qry) == FALSE)
		{
			die("Failed to Import rows from regularevents");
		}


		while ($row = $res->fetch_assoc()) 
		{
			//print_r($row);


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

			if ($resForthCheck->num_rows() == 0)
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

				if (! ($res = $this->oMysql->query($qry)))
				{
					die("Insert on calendar table failed");
				}

			}

		}

		$resForthCheck->free_result();
		$res-->free_result();


		return $str;

	}


	// $oDate - must be a datetime object
	private function weekOfMonth($oDate)
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



	// $oDate - must be a datetime object
	public function getEventStr($oDate)
	{
		$str = "";
		$dow = strtoupper($oDate->format("l")); // Day of Week MONDAY, TUESDAY etc
		$wom = weekOfMonth($oDate);  // Week of month - 1,2 etc

		$qry = " SELECT id, parentid, eventsource, eventdate, eventtime, eventname, " .
					 "        DATE_FORMAT(eventtime, '%l:%i %p') as disptime, linkurl " . 
		       " FROM calendar " . 
		       " WHERE eventdate = '" . date_format($oDate, 'Y-m-d') . "' " .
		       " ORDER BY eventtime";  
	
		if (! ($res = $this->oMysql->query($qry)))
		{
			die("<h1>SELECT on calendar table failed</h1>");
		}

		while ($row = $res->fetch_assoc()) 
		{
			$id = "id" . $row['id'];
			if ($row['eventsource'] == 'FORTHCOMING')
			{
				print("<div id=\"" . $id . "\" class=\"tip\">" . "Click to see event details" . "</div>\n");
				if (! empty($row['linkurl']) )
				{
					$str .= "<a href='" . $row['linkurl'];
					$str .= "#articleid" . $row['parentid'] . "' ";	// internal link on target page
				}
				else
				{
					$str .= "<a href='" . "index.php?displaypage=dispforthevent.php";
					$str .= "#articleid" . $row['parentid'] . "' ";	// internal link on target page
				}

				$str .= " onmouseout='popUp(event,\"" . $id . "\")'" . 
								" onmouseover='popUp(event,\"" . $id . "\")'  > \n"; // onclick='return false'
			} else if ($row['eventsource'] == 'REGULAR')
			{ 
				if (! empty($row['linkurl']) )
				{
					print("<div id=\"" . $id . "\" class=\"tip\">" . "Click to see event details" . "</div>\n");
					$str .= "<a href='" . $row['linkurl'] . "' ";
					$str .= " onmouseout='popUp(event,\"" . $id . "\")'" . 
									" onmouseover='popUp(event,\"" . $id . "\")' > \n"; // onclick='return false'
				}
			}

			$str .= "<h4>\n";
      //  FC_HIDE_TIME (11:11) is a magic time that means do not display time
			if (substr($row['eventtime'],0,5) !=  FC_HIDE_TIME ) 
			{
				//$str .= substr($row['eventtime'],0,5) . "<br />\n";
				$str .= $row['disptime'] . "<br />\n";
			}
			$str .= $row['eventname'] . "<br />\n";
			$str .= "</h4>\n";
			if ($row['eventsource'] == 'FORTHCOMING')
			{
				$str  .= "</a>\n";
			}	else if ($row['eventsource'] == 'REGULAR')
			{ // don't use a tool tip for regular events
				//$str  .= "</a>\n";
			}
		}

		$res->free_result();

		return $str;
	}

}; // End Class Calendar
  // =========================================================================

?>
