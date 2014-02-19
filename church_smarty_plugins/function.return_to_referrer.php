<?php


/* 
 * name: function.return_to_referrer.php
 * 
 * returns a link back to returning page
 * 
 */

error_reporting(E_ALL);

function smarty_function_return_to_referrer($params, $smarty)
{
	// Call example
	// return_to_referrer prompt="Back"} returns a link back to returning page
	$result = '';
	
	if (empty($params['prompt'])) 
	{
			trigger_error("prompt parameter is missing");
			return $result;
	}
	
	$result = "<a href='" . $_SERVER['HTTP_REFERER'] . 
						"' onclick='window.history.back();return false;' >" .
						$params['prompt'] . 
						"</a>\n";

	return $result;
}



?>
