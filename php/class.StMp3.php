<?php

/**
 * 
 * filename : class.StMp3.php
 *
 * Fetch MP3 sermons and talks.
 * 
 */

require_once('php/class.MysqliExtended.php');

// Encapsulate an MP3 Sermon
class StMp3Item
{
	
	public $aRec = [];
	
	function __construct(array $aRec) 
	{
		$this->aRec = $aRec;
	}
	
	function __destruct() 
	{
		
	}
	
};



// Fetch required set of rows
class StMp3 
{
	const FETCH_ALL		 = 'ALL';
	const FETCH_RECENT = 'RECENT';
	const DAYS_OLD = 7;
	
	const QRY_COLS = "id, filename, dateperformed, 
		            DATE_FORMAT(dateperformed, '%b %D %Y') AS datedisplay,
								DATEDIFF(CURRENT_DATE(), lastupdated) AS days_old,
								series, biblebook, bibleref, title, preacher, description,
								groupno, itemno";
	
	public $aStMp3Items = [];
	
	protected $rowType; // ALL or RECENT
	protected $daysOld;

	protected $rowCount = 0;	// count of rows returned by query
	
	function __construct($rowType = StMp3::FETCH_ALL, $daysOld = StMp3::DAYS_OLD) 
	{
		$this->aStMp3Items = [];
		$this->rowCount = 0;
		$this->daysOld = $daysOld;
		
		if (($rowType == StMp3::FETCH_ALL) || ($rowType == StMp3::FETCH_RECENT))
		{
			$this->rowType = $rowType;			
			
			if (($rowType == StMp3::FETCH_ALL))
			{
				$this->fetchAll();
			}

			if (($rowType == StMp3::FETCH_RECENT))
			{
				$this->fetchRecent();
			}			
			
		}
		else 
	  {
			throw new Exception("[" . $rowType . "] is not a valid FETCH type");			
		}
		


	}

	function __destruct() 
	{
		
	}

	protected function fetchAll()
	{
		$oMysql = MysqliExtended::getInstance();		
		$this->rowCount = 0;
		
		$qry = " SELECT	" . StMp3::QRY_COLS . 
					 " FROM sermonstalks " . 
					 " ORDER BY groupno, itemno DESC";  	
		
		$res = $oMysql->query($qry);
		
		if (! $res)
		{
			throw new Exception("Query [" . $qry . "] failed Error [" . 
													$oMysql->error . "]");
		}
		
		$this->rowCount = $res->num_rows;
		
    /* fetch associative array */
    while ($row = $res->fetch_assoc()) 
		{
			$this->aStMp3Items [] = new StMp3Item($row);
    }

    /* free result set */
    $res->free();		
		
	}
	
	protected function fetchRecent() 
	{
		$oMysql = MysqliExtended::getInstance();
		$this->rowCount = 0;
		
		$qry = " SELECT	" . StMp3::QRY_COLS . 
					 " FROM sermonstalks " . 
					 " WHERE DATEDIFF(CURRENT_DATE(), lastupdated) <= " . $this->daysOld .
					 " ORDER BY lastupdated DESC";  	
		
		$res = $oMysql->query($qry);
		
		if (! $res)
		{
			throw new Exception("Query [" . $qry . "] failed Error [" . 
													$oMysql->error . "]");
		}
		
		$this->rowCount = $res->num_rows;
		
    /* fetch associative array */
    while ($row = $res->fetch_assoc()) 
		{
			$this->aStMp3Items [] = new StMp3Item($row);
    }

    /* free result set */
    $res->free();		
		
	}
	
};




?>