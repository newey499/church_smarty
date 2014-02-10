<?php
/*******************************

filename: class.Menu.php

**********************************/
require_once('php/class.MysqliExtended.php');

class MenuException extends Exception
{
	function __construct($message, $code = 0, Exception $previous = NULL) 
	{
		parent::__construct($message, $code, $previous);
	}
}

class MenuBase
{
	const SELECT_COLUMNS = 
	' id, itemtype, itemgroup, itemorder, isvisible, prompt, target, content, menucol, lastupdate ';
	
	public $id;
	public $itemtype;
	public $itemgroup;
	public $itemorder;
	public $isvisible;
	public $prompt;
	public $target;
	public $content;
	public $menucol;
	public $lastupdate;
	
	public $oMysqli;
	
	function __construct() 
	{
		//$this->oMysqli = new  MysqliExtended();
		$this->oMysqli = MysqliExtended::getInstance();
	}
	
	function __destruct() 
	{
		//$this->oMysqli->close();
	}
	
	protected function loadRow(array $row) 
	{
		$this->id         = $row['id'];
		$this->itemtype   = $row['itemtype'];
		$this->itemgroup  = $row['itemgroup'];
		$this->itemorder  = $row['itemorder'];
		$this->isvisible  = $row['isvisible'];
		$this->prompt     = $row['prompt'];
		$this->target     = $row['target'];
		$this->content    = $row['content'];
		$this->menucol    = $row['menucol'];
		$this->lastupdate = $row['lastupdate'];		
	}
	
}

class MenuItem extends MenuBase
{

	public $lastupdatedays;
	public $menuitemlink;
	
	function __construct($row = NULL) 
	{
		parent::__construct();
		
		$this->loadRow($row);	
		$this->calcLastUpdatedDays();
		$this->createLink();		
	}
	
	protected function calcLastUpdatedDays()
	{
		$dateNow = new DateTime();
		$dateUpdated = new DateTime($this->lastupdate);
		$interval = $dateNow->diff($dateUpdated);

		$this->lastupdatedays = $interval->days;		
	}
	
	protected function createLink()
	{
		$result = "menuitemlink var not set";
		if (! empty(trim($this->target)))
		{
			$result = "<a href='" . $this->target . "'>" . $this->prompt . "</a>";
		}
		else 
		{
			$result = "<a href='index.php?id=" . $this->id . "'>" . $this->prompt . "</a>";
		}			
		
		//print("$result<br>");

		$this->menuitemlink = $result;
	}
	
}

class MenuGroup extends MenuBase
{
	
	public $aMenuItems = [];
	
	function __construct($row) 
	{
		parent::__construct();
		
		$this->loadRow($row);			
		$this->loadMenuItems($row['itemgroup']);
	}
	
	
	protected function loadMenuItems($itemgroup)
	{
		$qry = " SELECT " . Menu::SELECT_COLUMNS .
			     " FROM menuitems " .
			     " WHERE itemgroup = " . $itemgroup . 
					 "   AND isvisible = 'YES'" .
					 " ORDER BY itemorder";
		
		$res = false;
		$res = $this->oMysqli->query($qry);
		if (!$res)
		{
			throw new MenuException("SQL Query failed [$qry] ");
		}						 
		
    /* fetch associative array */
    while ($row = $res->fetch_assoc()) 
		{
			$this->aMenuItems[] = new MenuItem($row);
    }		
		
		// Free resultset
		$res->free_result();
	}	
	
}



class Menu extends MenuBase
{

	const LEFT  = 'LEFT';
	const RIGHT = 'RIGHT';
	
	public $aMenuGroups = [];
	
	function __construct($menuSide = '') 
	{
		parent::__construct();
		
		if (!($menuSide == Menu::LEFT || $menuSide == Menu::RIGHT))
		{
			throw new MenuException("[$menuSide] is not a valid menu side");
		}

		$this->loadMenuGroups($menuSide);
		
		//var_dump($this);	
		
	}
	
	function __destruct()
	{
		parent::__destruct();
	}
	
	
	public static function getMenuItemContent($id)
	{
		$oMysqli = MysqliExtended::getInstance();
		$content = "<h4>content not found for id [$id]</h4>";
		
		$qry = "SELECT content from menus WHERE id = " . $id;
		
		$res = FALSE;
		$res = $oMysqli->query($qry);
		if (! $res)
		{
			throw new MenuException("SQL Query failed [$qry] ");
		}
		
		$row = FALSE;
		if ($row = $res->fetch_assoc())
		{
			$content = $row['content'];
		}
		
		// Free resultset
		$res->free_result();		
		
		//print("<h4>content [$content]</h4>");
		
		return $content;
	}
	
	protected function loadMenuGroups($menuSide)
	{
		$qry = " SELECT " . Menu::SELECT_COLUMNS .
			     " FROM menutitles " .
			     " WHERE menucol = '" . $menuSide . "'" .
					 "   AND isvisible = 'YES'" .
					 " ORDER BY itemgroup";
		
		$res = false;
		$res = $this->oMysqli->query($qry);
		if (!$res)
		{
			throw new MenuException("SQL Query failed [$qry] ");
		}						 
		
    /* fetch associative array */
    while ($row = $res->fetch_assoc()) 
		{
			$this->aMenuGroups[] = new MenuGroup($row);
    }		
		
		// Free resultset
		$res->free_result();
	}
	
	
}
