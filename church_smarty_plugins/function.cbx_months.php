<?php

/* 
 * name: function.date_now_format.php
 * 
 * Smarty plugin to format current datetime
 * 
 */

error_reporting(E_ALL);

function smarty_function_cbx_months($params, $smarty)
{
	// Call example
	// {cbx_months months=3} return string containing combobox for specified number of months
	$result = '';
	
	if (empty($params['months'])) 
	{
			trigger_error("months parameter is missing");
			return $result;
	}

	$date = new DateTime();
	
	$result =  "<select name=\"calmonth\"";
	$result .= " id=\"calmonth\" ";
	//$result .= " onchange=\"alert('cbx calmonth [' + document.getElementById('calmonth').value + ']'); return false; \" ";
	$result .= " onchange=\"changeCalendarMonth(document.getElementById('calmonth').value, ";
	$result .= " 'index.php?id=101' ); return false; \" ";	
	$result .= " >\n";

	if (! isset($_GET['calmonth']))
	{
		$_GET['calmonth'] = $date->format("Yn");
	}
	
	for ($i = 0; $i < $params['months']; $i++)
	{
		// $result .= $date->format("d-m-Y H:i:s") . "<br />\n";

		// 4 digit year + month without leading zero
		$result .= "<option value=\"" . $date->format("Yn") . "\" ";

		//if ($month == $_POST['calmonth']) 
		if ($_GET['calmonth'] == $date->format("Yn")) 			
		{
			$result = $result . " selected "; 
			$year = substr($_GET['calmonth'], 0, 4);
			$month = substr($_GET['calmonth'], 4);
			$smarty->assign('year', $year);
			$smarty->assign('month', $month);			
		}

		$result .= " >";
		$result .= $date->format("M Y") . "</option>\n";

		$date->modify("+1 month");

	}

	$result = $result . "</select>\n\n";

	return $result;	
}



?>



