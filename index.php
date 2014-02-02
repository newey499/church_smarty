<?php

error_reporting(E_ALL);

require_once('php/class.SmartyExtended.php');
require_once('php/class.MysqliExtended.php');

$mysqli = new MysqliExtended();

$smarty = new SmartyExtended();

$smarty->assign('name','Chris');

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

require_once('php/header.php');

print("========= Start Smarty generated content =========");
	$smarty->display('index.tpl');
print("\n========= End Smarty generated content   =========<br>\n");

require_once('php/footer.php');

?>
