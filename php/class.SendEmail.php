<?php

/**
 * Description of class
 *
 * file: classSendEmail.php
 * 
 * Class SendEmail
 * 
 */

require_once('php/phpmailer/class.phpmailer.php');


class SendEmail
{
	
	public $oMailer     = NULL;
	public $aErrors     = [];
	public $validEmail  = true;
	public $sendEmail   = false;
	public $emailSentOk = false;
	public $to          = "";
	public $from        = "";
	public $subject     = "";
	public $body        = "";

	//put your code here
	function __construct($sendEmail) 
	{
		$this->oMailer     = new PHPMailer(false); // true = throw exceptions, false = don't throw exceptions
		$this->aErrors     = [];
		$this->validEmail  = true;
		$this->sendEmail   = $sendEmail;
		$this->emailSentOk = false;
		
		$this->to          = "";
		$this->from        = "";
		$this->subject     = "";
		$this->body        = "";		
		
	}

	function __destruct() 
	{
		
	}
	
	public function exec($to, $replyto1, $replyto2, $subject, $body)
	{
		$result = false;
		
		$this->to      = $to;
		$this->from    = $replyto1; // validate replyto1 == replyto2 - throw exception if not
		$this->subject = $subject;
		$this->body		 = $body;
		
		if ($this->validate())
		{
			if ($this->sendEmail())
			{
				$result = true;
				$this->emailSentOk = true;				
			}
		}
		
		return $result;
	}
	
	protected function validate()
	{
		$result = true;
		
		return $result;
	}
	
	protected function sendEmail()
	{
		$result = true;
		
		return $result;
	}

};
