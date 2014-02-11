<?php

/* 
 * name: function.get_menu.php
 * 
 * Smarty plugin to build left and right side menus
 * 
 */

error_reporting(E_ALL);

function smarty_function_get_menu($params, $smarty)
{
	// Call example
	// {get_menu menu_side="LEFT" out="oMenuLeft"}
	
	require_once('php/class.Menu.php');
	
	if (empty($params['menu_side'])) 
	{
			trigger_error("assign: missing 'menu_side' parameter");
			return;
	}
	else
	{
		if ( ! (Menu::LEFT == $params['menu_side'] || Menu::RIGHT == $params['menu_side']))
		{
				trigger_error("assign: missing 'menu_side' parameter contains [" . 
					            $params['menu_side'] .
											"] nor 'LEFT' or 'RIGHT'");
				return;
		}			
	}

	if (!in_array('out', array_keys($params))) 
	{
			trigger_error("assign: missing 'out' parameter");
			return;
	}

	
	$oMenu  = new Menu($params['menu_side']);	

	//$smarty->assign($params['out'], $oMenu);  
	$smarty->assign($params['out'], $oMenu);  	
	
	
	return;	
}



?>