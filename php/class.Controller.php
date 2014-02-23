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
		
	// At this point $id has been validated to be a valid +ve integer
	protected function getContentById($id)
	{
		$this->contentResult = "protected function getContentById($id)";

		$this->oSmarty->assign('primary_key_menu_id', $id);

		$row = Menu::getMenuItemContent($id);

		/*******************
		 * 
		 * Hierarchy is:
		 *  1) If we get here the the content is not an external website.
		 *	2) If menus.smartytemplate is not empty read the contents of the file 
		 *     and use as content.
		 *  3) If menus.smartytemplate is empty read the contents of the menus.content column 
		 *     and use as content.
		 */

		if (empty($row['smartytemplate']))
		{
			$this->contentResult = $row['content'];	
		}
		else 
		{
			if (isSmartyTemplateFile($row['smartytemplate']))
			{
					if (! file_exists($row['smartytemplate']))
					{
						$this->contentResult = "<h4>Smarty template file [" . $row['smartytemplate'] . "] not found.</h4>";	
					}
					else 
					{
						$this->contentResult = file_get_contents($row['smartytemplate']);
						if ($this->contentResult === false)
						{
							throw new LogErrorException("Template file [" . $filename . "] content empty or not read", 3);								
						}	
					}

			}

		}

		$this->oSmarty->assign('centreColumnContent', $this->contentResult);		

		$this->oSmarty->assign('pageTitle', $row['prompt']);
		
		return $this->contentResult;
	}

	protected function getContentByTemplateFilename($filename)
	{	
		if (! file_exists($filename))
		{
			throw new LogErrorException("Template file [$filename] does not exist", 4);	
		}
		else 
		{
			$this->contentResult = file_get_contents($filename);
			if ($this->contentResult === false)
			{
				throw new LogErrorException("Template file [" . $filename . "] content empty or not read", 5);				
			}	
		}
		
		$this->oSmarty->assign('centreColumnContent', $this->contentResult);	
		$this->oSmarty->assign('pageTitle', 'Page Title not set');		

		return $this->contentResult;
	}	
	
};


// =============================================================