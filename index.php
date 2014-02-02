<?php

require_once('includes/class.SmartyExtended.php');

$smarty = new SmartyExtended();

$smarty->assign('name','Chris');

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

require_once('includes/header.php');



print("========= Start Smarty generated content =========");
	$smarty->display('index.tpl');
print("\n========= End Smarty generated content   =========<br>\n");

require_once('includes/footer.php');

?>
