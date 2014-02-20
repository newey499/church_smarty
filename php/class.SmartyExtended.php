
<?php

// File: class.SmartyExtended.php

// *nix style (note capital 'S')
//define('SMARTY_DIR', '/usr/local/lib/Smarty-v.e.r/libs/');

// windows style
define('SMARTY_DIR', 'c:/utils/php/smarty-3.1.16/libs/');

// load Smarty library
// NOTE: (for ?nix - Smarty has a capital 'S'
require_once(SMARTY_DIR . 'Smarty.class.php');

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

        $this->addTemplateDir('./templates/');
				$this->addTemplateDir('./media/templates'); // Dir contains text sermon templates
					
        $this->setCompileDir('./templates_c/');
        $this->setConfigDir('./configs/');
        $this->setCacheDir('./cache/');

				// add directory where local plugins are stored
				$this->addPluginsDir('./church_smarty_plugins');		
				
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