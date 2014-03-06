<?php

/* 
 * filename: test.php
 * 
 * scratch file to testing odd bits of php
 * 
 */

require_once('php/class.StMp3.php');

class test
{
	public $aErrors     = NULL;	
	
	function __construct()
	{
		$this->aErrors     = [
												'to'       => [],
												'replyto1' => [],
												'replyto2' => [],
												'subject'  => [],
												'body'     => []
										 ];

		
		$this->exec();
	}
	
	protected function exec()
	{
		$this->aErrors['replyto1'][] = 'Email from addresses do not match';		
		$this->aErrors['replyto1'][] = '"Your Email" may not be empty';
		$this->aErrors['replyto2'][] = '"Confirm Email" may not be empty';	
		
		$this->aErrors['replyto1'][] = 'Email from addresses do not match';		
			
		print_r($this);
	}
	
}

print("test.php start\n\n");

//$oTest = new test();
$oStMp3 = new StMp3();
$oStMp31 = new StMp3(StMp3::FETCH_RECENT);

print_r($oStMp31);

print("\ntest.php end");


?>

