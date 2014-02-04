
<?php

// File: class.SmartyExtended.php

// load Smarty library
// NOTE: (for ?nix - Smarty has a capital 'S'
require_once('c:/utils/php/smarty-3.1.16/libs/Smarty.class.php');

// The setup.php file is a good place to load
// required application library files, and you
// can do that right here. An example:
// require('guestbook/guestbook.lib.php');

class SmartyExtended extends Smarty {

	 const APPLICATION_NAME = 'Smarty';
	 
   function __construct()
   {

        // Class Constructor.
        // These automatically get set with each new instance.

        // Call the parent constructor first
        parent::__construct();

        $this->setTemplateDir('./templates/');
        $this->setCompileDir('./templates_c/');
        $this->setConfigDir('./configs/');
        $this->setCacheDir('./cache/');

        $this->caching = Smarty::CACHING_LIFETIME_CURRENT;

        $this->assign('app_name', self::APPLICATION_NAME);
   }
   
   
   function __destruct()
   {
	   
	   // Call the parent destructor last
	   parent::__destruct();
   }
   
	
}

?>