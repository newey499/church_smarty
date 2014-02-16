<?php

error_reporting(E_ALL);

function smarty_function_create_calendar_table($params, $smarty)
{
	// Call example
	// {create_calendar_table month='month' year='year' out="oCalendar"}
	
	require_once('php/class.Calendar.php');

	echo "GET";
	var_dump($_GET);
	echo "POST";
	var_dump($_POST);	
	return;
	
	if (!in_array('month', array_keys($params))) 
	{
			trigger_error("assign: missing 'month' parameter");
			return;
	}	

	if (!in_array('year', array_keys($params))) 
	{
			trigger_error("assign: missing 'year' parameter");
			return;
	}		
	
	if (!in_array('out', array_keys($params))) 
	{
			trigger_error("assign: missing 'out' parameter");
			return;
	}

	$oCalendar  = new Calendar($params['month'], $params['year']);	

	$smarty->assign($params['out'], $oCalendar);  	
	

	
	return;	
}



?>