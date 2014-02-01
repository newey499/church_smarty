<?php
require_once('includes/header.php');

require_once('includes/class.SmartyExtended.php');

$smarty = new SmartyExtended();

$smarty->assign('name','Chris');

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

print("========= Start Smarty generated content =========\n");
$smarty->display('index.tpl');
print("========= End Smarty generated content   =========<br>\n");

require_once('includes/footer.php');
?>
