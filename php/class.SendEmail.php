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
	public $aErrors     = NULL;
	public $validEmail  = true;
	public $sendEmail   = false;
	public $emailSentOk = false;
	public $to          = "";
	public $from        = "";
	public $subject     = "";
	public $body        = "";

	function __construct($sendEmail) 
	{
		$this->aErrors     = [
														'to'       => array(),
														'replyto1' => array(),
														'replyto2' => array(),
														'subject'  => array(),
														'body'     => array()
			                   ];
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
		// $this->from    = ''; // validate replyto1 == replyto2 - throw exception if not
		$this->subject = $subject;
		$this->body		 = $body;
		
		if ($this->validate($replyto1, $replyto2))
		{
			if ($this->sendEmail())
			{
				$result = true;
				$this->emailSentOk = true;				
			}
		}
		
		return $result;
	}
	
	protected function validate($replyto1, $replyto2)
	{
		$result = true;
		
		if (empty($replyto1))
		{
			$this->aErrors['replyto1'] [] = '"Your Email" may not be empty';		
			$result = false;			
		}

		if (empty($replyto2))
		{
			$this->aErrors['replyto2'] [] = '"Confirm Email" may not be empty';		
			$result = false;			
		}
		
		if (strtoupper(trim($replyto1)) == strtoupper(trim($replyto2)))
		{
			$this->from    = $replyto1; 		
			
			// If we get this far then the Email reply addresses are equal and
			// not empty so finally check that the contain a valid email address.
			if (! filter_var($replyto1, FILTER_VALIDATE_EMAIL))
			{
				$this->aErrors['replyto1'] [] = '"' . $replyto1 . '" is not a valid email address';
				$result = false;
			}			
		}
		else 
		{
			$this->aErrors['replyto1'] [] = 'Email reply addresses do not match';
			$result = false;
		}		
		
		if (empty($this->subject))
		{
			$this->aErrors['subject'] [] = '"Subject" may not be empty';		
			$result = false;			
		}
		
		if (empty($this->body))
		{
			$this->aErrors['body'] [] = '"Content" may not be empty';		
			$result = false;			
		}
		
		$this->validEmail  = $result;		
		
		if (! $result)
		{
			return $result;
		}
			
		//var_dump($this->aErrors);
		//print_r($this);
		
		return $result;
	}
	
	protected function sendEmail()
	{
		$oMailer     = new PHPMailer(false); // true = throw exceptions, false = don't throw exceptions		
		
		$result = true;
		
		return $result;
	}

};
