<?php

/****************************************** 

filename: class.ForthcomingEvents.php

 ******************************************/
require_once 'php/class.MysqliExtended.php';

class ForthcomingEvents
{
	public $searchExpr = "";
	public $aEvents = [];
	public $qry;
	
	function __construct() 
	{
		
		$this->getForthcomingEvents();
		
		//var_dump($this);
		//print_r($this);		
	}
	
	function __destruct() 
	{

	}

	protected function getForthcomingEvents()
	{
		$oMysqli = MysqliExtended::getInstance();
		
		$this->qry = "SELECT	id,
										orgid,
										DATE_FORMAT(eventdate,'%W %D %M %Y') as displayEventDate,
										DATE_FORMAT(eventdate,'%W %D %M %Y at %l:%i%p') as displayEventDateTime,
										DATE_FORMAT(eventdate,'%H:%i') as eventTime,
										eventname,
										eventdesc,
										contribemail,
										contactname,
										contactphone,
										contactemail,
										isvisible
						FROM forthcomingevents ";

		if (! empty($_POST['forthcomingeventsearch']))
		{
			$this->searchExpr = $oMysqli->real_escape_string($_POST['forthcomingeventsearch']);
			$like = '%' . $oMysqli->real_escape_string($_POST['forthcomingeventsearch']) . '%';
			$this->qry .= " WHERE eventname LIKE '" . $like . "'" .
							" OR eventdesc LIKE '" . $like . "'" .
							" OR contribemail LIKE '" . $like . "'" .
							" OR contactname LIKE '" . $like . "'" .
							" OR contactphone LIKE '" . $like . "'" .
							" OR contactemail LIKE '" . $like . "'" .
							" OR DATE_FORMAT(eventdate,'%H:%i') LIKE '" . $like . "'" .
							" OR DATE_FORMAT(eventdate,'%W %D %M %Y at %l:%i%p') LIKE '" . $like . "'" .
							" OR DATE_FORMAT(eventdate,'%W %D %M %Y') LIKE '" . $like . "'";

		}

		$this->qry .= " ORDER BY eventdate";

		$result = $oMysqli->query($this->qry) or die('Query failed: ' . $oMysqli->error());

		if ($result->num_rows == 0)
		{
			// CDN 4/1/10 - Tweak message slightly to take account of empty $_POST['forthcomingeventsearch'] string
			if (! empty($_POST['forthcomingeventsearch']))
			{
				print("<h4>No Events found containing [" . $_POST['forthcomingeventsearch'] . "]</h4>\n");	
			}
			else
			{
				print("<h4>No Forthcoming Events found.</h4>\n");
			}
		}	
		else 
		{
			$this->getRows($result);
		}
	}
	
	protected function getRows($result)
	{
		$row = false;
		
		while ($row = $result->fetch_assoc())
		{
			$this->aEvents [] = $row;
		}
	
	}

};

?>