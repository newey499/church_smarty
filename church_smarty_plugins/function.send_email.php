<?php


/* 
 * name: function.send_email.php
 * 
 * Smarty plugin to validate and send emails
 * 
 */

error_reporting(E_ALL);

function smarty_function_send_email($params, $smarty)
{
	// Call example
	// {send_email input="EXAMPLE" out="oEmail"}
	
	require_once('php/class.SendEmail.php');
	
	if (empty($params['input'])) 
	{
			trigger_error("assign: missing 'input' parameter");
			return;
	}
	else
	{
		/***********************
		if ( ! (Menu::LEFT == $params['menu_side'] || Menu::RIGHT == $params['menu_side']))
		{
				trigger_error("assign: missing 'menu_side' parameter contains [" . 
					            $params['menu_side'] .
											"] nor 'LEFT' or 'RIGHT'");
				return;
		}			
		*****************************/
	}

	if (!in_array('out', array_keys($params))) 
	{
			trigger_error("assign: missing 'out' parameter");
			return;
	}

	$oMailer = new SendEmail(isset($_POST['sendemail']));
	
	if (! isset($_POST['sendemail']))
	{
		print("<h4>sendemail not set</h4>");
	}
  else 
	{
		print("<h4>sendemail is set</h4>");	
		$oMailer->exec( $_POST['emailrecipient'],
										$_POST['emailreplyto1'],
										$_POST['emailreplyto2'],			
										$_POST['emailsubject'],
										$_POST['emailtext']);
	}

	//var_dump($oMailer);


	$smarty->assign($params['out'], $oMailer);  	
	
	return;	
}



?>

