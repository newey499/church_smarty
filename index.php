<?php

error_reporting(E_ALL);

require_once('php/class.SmartyExtended.php');
require_once('php/class.MysqliExtended.php');
require_once('php/class.Menu.php');
require_once('php/genlib.php');

$oMysqli = MysqliExtended::getInstance();

$oSmarty = new SmartyExtended();
//** un-comment the following line to show the debug console
//$oSmarty->debugging = true;
// add directories where plugins are stored
$oSmarty->setPluginsDir('./church_smarty_plugins');

//$oMenuLeft  = new Menu(Menu::LEFT);
//$oSmarty->assign('oMenuLeft', $oMenuLeft->aMenuGroups);

//$oMenuRight = new Menu(Menu::RIGHT);
//$oSmarty->assign('oMenuRight', $oMenuRight->aMenuGroups);

$oSmarty->clearCache('index.tpl');

$oSmarty->assign('app_name', "church_smarty");
$oSmarty->assign('name', "<H1>Chris</H1>");
$oSmarty->assign('lastUpdatedDateTime', getLastUpdateTimestamp());


if (isset($_GET['id']))
{
	$oSmarty->assign('primaryKeyId', $_GET['id']);	
}
else 
{
	$oSmarty->assign('primaryKeyId', "Not Set");
}


if (isset($_GET['id']) && is_int((int) $_GET['id']))
{
	$id = $_GET['id'];
}
else 
{
	$id = "1";
}
//print("<h1>id [" . $id . "]</h1>");

$centreColumnContent = Menu::getMenuItemContent($id);
$oSmarty->assign('centreColumnContent', $centreColumnContent);

//require_once('php/header.php');

// ========= Start Smarty generated content =========
$oSmarty->display('index.tpl');
// ========= End Smarty generated content   =========

//require_once('php/footer.php');

?>
