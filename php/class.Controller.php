<?php

error_reporting(E_ALL);

require_once('php/class.SmartyExtended.php');
require_once('php/class.MysqliExtended.php');
require_once('php/class.Menu.php');
require_once('php/genlib.php');


/**
 * Description of class
 *
 * @author cdn
 */
class Controller 
{
	protected $aGet = [];
	protected $oSmarty = NULL;
	protected $contentResult = "Controller->getCentreContent() start - no content found";

	function __construct(array $aGet = [], SmartyExtended $oSmarty = NULL) 
	{
		$this->aGet = $aGet;
		$this->oSmarty = $oSmarty;
	}

	function __destruct() 
	{
		
	}
	
	public function getCentreContent()
	{

		try 
		{
			if (isset($this->aGet['tpl']))
			{
				// Process a Smarty template file passed in the $_GET array
				print('<h2>Process a Smarty template file passed in the $_GET array</h2>');
			}			
			elseif (isset($this->aGet['id'])) 
			{
				// Process a primary key (id) on menus table passed in the $_GET array
				print('<h2>Process a primary key (id) on menus table passed in the $_GET array</h2>');				
			}
			else 
			{
				throw new Exception("Neither tp filename or menus primary key in GET array");
			}
			
		} 
		catch (Exception $ex) 
		{
			print("<h2>" . $ex->getMessage() . "</h2>");
		}


	}

};


// =============================================================
