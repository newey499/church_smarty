<?php

/**
 * Description of class LogErrorException
 *
 * @author cdn 
 * 
 * 20/02/2014	CDN				Created
 * 
 * 
 * 
 */

error_reporting(E_ALL);

require_once('php/class.MysqliExtended.php');

class LogErrorException extends Exception
{

	function __construct($message, $code = 0, Exception $previous = null) 
	{
		parent::__construct($message, $code, $previous);
		
		$this->buildTable();
		
		$this->logError();
	}

	function __destruct() 
	{
		
	}
	
	protected function buildTable() 
	{
		$oMysql = MysqliExtended::getInstance();
		
		$qryDropTable   = "DROP TABLE IF EXISTS logerror";
		$qryCreateTable = " CREATE TABLE IF NOT EXISTS logerror " .
											" ( " .
											" 	id INT AUTO_INCREMENT, " .
											" 	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, " .
											" 	lastupdated TIMESTAMP NOT NULL DEFAULT NOW(), " .
											"  " .
											" 	message TEXT NOT NULL, " .
											" 	code INT NOT NULL, " .
											" 	filename VARCHAR(250) NOT NULL, " .
											" 	line  INT NOT NULL, " .
											" 	trace TEXT, " .
											" 	exceptionstring TEXT, " .
											"  " .
											" 	PRIMARY KEY(id) " .
											"  " .
											" ) ENGINE=MyIsam ";

		/***************
		if (! $oMysql->query($qryDropTable))
		{
			die("Failed to drop logerror table");
		}
		************************/
		
		if (! $oMysql->query($qryCreateTable))
		{
			die("Failed to create logerror table");
		}
	
	}
	
	protected function logError()
	{
		$oMysql = MysqliExtended::getInstance();
		$filename = $this->getFile();
		$filename = str_replace('\\', '/', $filename);
		
		// @todo This is redundant but mucking around with the array to format it
		// for MySql can wait
		$traceArray = $this->getTraceAsString();
		
		$qry = ' INSERT INTO logerror ' .
					 ' ( ' . 
					 '		message, code, filename, line, ' .
					 '		trace, exceptionstring ' .	
					 ' ) ' .
					 ' VALUES ' . 
					 ' ( ' . 
					 '		"' . $this->getMessage() . '", ' .
					 '		"' . $this->getCode() . '", ' .
					 '		"' . $filename . '", ' .
					 '		"' . $this->getLine() . '", ' .
					 '		"' . $traceArray . '", ' .  
					 '		"' . $this->getTraceAsString() . '" ' .			
					 ' ) ';
		
		if (! $oMysql->query($qry))
		{ 
			die("<h4>QUERY <br>[" . $qry . "]<br><br> Failed - error [" . $oMysql->error . "]</h4>");
		}
		else 
		{
			//print("<h4>stmt->execute OK</h4>");		
		}
			
	}

};

?>
