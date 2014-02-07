<?php

error_reporting(E_ALL);

require_once('php/class.SmartyExtended.php');
require_once('php/class.MysqliExtended.php');

$mysqli = new MysqliExtended();

$smarty = new SmartyExtended();

$smarty->clearCache('index.tpl');

$smarty->assign('app_name', "church_smarty");
$smarty->assign('name', "<H1>Chris</H1>");

$smarty->assign('primaryKeyId', "Not Set");

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

require_once('php/header.php');

// ========= Start Smarty generated content =========
	$smarty->display('index.tpl');
// ========= End Smarty generated content   =========

require_once('php/footer.php');

?>
