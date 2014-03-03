<?php

/* 
 * name: smarty_function_write_image_tag.php
 * 
 * Smarty plugin to validate and send emails
 * 
 */

error_reporting(E_ALL);

function smarty_function_write_image_tag($params, $smarty)
{
	// Call example
	// {write_image_tag href=="images/abc123.jpg" 
	//                  src="images/xyz789.jpg"
	//                  size="250Kb"}
	
	if (empty($params['href'])) 
	{
			trigger_error("assign: missing 'href' parameter");
			return '';
	}	
	if (empty($params['src'])) 
	{
			trigger_error("assign: missing 'src' parameter");
			return '';
	}	
	if (empty($params['size'])) 
	{
			trigger_error("assign: missing 'size' parameter");
			return '';
	}		
	
	$href = $params['href'];
	$src  = $params['src'];
	$size = $params['size'];	
	
	
	
	$result = '';

	$result .= "<td  class='thumbnail'>\n";
	$result .= "<a href='jpgdisp.php?jpgurl=" . $href . "' >\n";
	$result .= "<img class='thumbnail' src='" . $src . "' \n"; 
	$result .= "     alt='Click to view in new window' \n";
	$result .= "     title='Click to view in new window' \n";
	$result .= "	/>\n"; 
	$result .= "<br /> \n";
	$result .= $size;  
	$result .= "</a> \n";
	$result .= "</td>\n";
	
	return $result;
}







?>