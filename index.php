<?php

error_reporting(E_ALL);

require_once('php/class.SmartyExtended.php');
require_once('php/class.MysqliExtended.php');
require_once('php/class.Controller.php');
require_once('php/class.Menu.php');
require_once('php/genlib.php');

$oMysqli = MysqliExtended::getInstance();

$oSmarty = new SmartyExtended();
//** un-comment the following line to show the debug console
//$oSmarty->debugging = true;
$oSmarty->clearCache('index.tpl');

$oSmarty->assign('app_name', "church_smarty");
$oSmarty->assign('lastUpdatedDateTime', getLastUpdateTimestamp());

$oController = new Controller($_GET, $oSmarty);
$oController->getCentreContent();


// ========= Start Smarty generated content =========
$oSmarty->display('index.tpl');
// ========= End Smarty generated content   =========

?>
