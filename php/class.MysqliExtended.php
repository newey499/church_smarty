<?php
/***********************************

file: class.Mysqli.Extended.php


************************************/
require_once('config/configDb.php');

class MysqliExtended extends mysqli 
{

	    public function __construct($host = ConfigDb::HOST, 
	    														$user = ConfigDb::USER, 
	    														$pass = ConfigDb::PASS,
	    														$db   = ConfigDb::DB) 
	    {
		    
        parent::__construct($host, $user, $pass, $db);

        if (mysqli_connect_error()) 
        {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
    }
    
    
}





?>