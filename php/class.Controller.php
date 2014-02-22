<?php

error_reporting(E_ALL);

require_once('config/globals.php');
require_once('php/class.LogErrorException.php');
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
	const HOME_PAGE_PRIMARY_KEY_ID = 1;
	
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
				$this->getContentByTemplateFilename($this->aGet['tpl']);
			}			
			elseif (isset($this->aGet['id'])) 
			{
				// Process a primary key (id) on menus table passed in the $_GET array
	
				if (isset($_GET['id']) && is_int((int) $_GET['id']))
				{
					$id = $_GET['id'];
				}
				else 
				{
					throw new LogErrorException("Menu table primary key [" . $id . "] is not a valid positive integer", 1);
				}		

				if (intval($id) <= 0)
				{
					throw new LogErrorException("Menu table primary key [" . $id . "] is not a valid positive integer", 2);			
				}				
				$this->getContentById($this->aGet['id']);				
			}
			else 
			{				
				$this->aGet['id'] = Controller::HOME_PAGE_PRIMARY_KEY_ID;
				$this->getContentById($this->aGet['id']);
			}
			
		} 
		catch (Exception $ex) 
		{				
			$this->aGet['id'] = Controller::HOME_PAGE_PRIMARY_KEY_ID;
			$this->getContentById($this->aGet['id']);			
		}
		
		return $this->contentResult;

	}
		
	protected function getContentByTemplateFilename()
	{
		return "protected function getContentByTemplateFilename";
	}


	
};


// =============================================================