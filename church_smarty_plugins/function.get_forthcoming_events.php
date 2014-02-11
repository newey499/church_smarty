<?php

/* 
 * name: function.get_forthcoming_events.php
 * 
 * Smarty plugin to build Forthcoming Events array
 * 
 */

error_reporting(E_ALL);

function smarty_function_get_forthcoming_events($params, $smarty)
{
	// Call example
	// {get_forthcoming_events out="oForthcomingEvents"}
	
	require_once('php/class.ForthcomingEvents.php');
	
	if (!in_array('out', array_keys($params))) 
	{
			trigger_error("assign: missing 'out' parameter");
			return;
	}

	$oFe  = new ForthcomingEvents();	

	$smarty->assign($params['out'], $oFe);  	
		
	return;	
}



?>