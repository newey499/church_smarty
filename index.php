<?php

error_reporting(E_ALL);

require_once('php/class.SmartyExtended.php');
require_once('php/class.MysqliExtended.php');
require_once('php/class.Menu.php');

$oMysqli = new MysqliExtended();

$oSmarty = new SmartyExtended();

$oMenuLeft  = new Menu(Menu::LEFT);
$oSmarty->assign('oMenuLeft', $oMenuLeft->aMenuGroups);

$oMenuRight = new Menu(Menu::RIGHT);
$oSmarty->assign('oMenuRight', $oMenuRight->aMenuGroups);

$oSmarty->clearCache('index.tpl');

$oSmarty->assign('app_name', "church_smarty");
$oSmarty->assign('name', "<H1>Chris</H1>");

$oSmarty->assign('primaryKeyId', "Not Set");

//** un-comment the following line to show the debug console
//$oSmarty->debugging = true;

require_once('php/header.php');

// ========= Start Smarty generated content =========
	$oSmarty->display('index.tpl');
// ========= End Smarty generated content   =========

require_once('php/footer.php');

?>
