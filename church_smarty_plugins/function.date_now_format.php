<?php

/* 
 * name: function.date_now_format.php
 * 
 * Smarty plugin to format current datetime
 * 
 */

error_reporting(E_ALL);

function smarty_function_date_now_format($params, $smarty)
{
	// Call example
	// {date_now_format format="Y"} return 4 digit year

	if (empty($params['format'])) 
	{
			trigger_error("format parameter is missing");
			return "";
	}

	$date = new DateTime(); // php defaults to current datetime
	$result = $date->format($params['format']);

	return $result;	
}



?>

