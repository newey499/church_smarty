<html>

<body>

<h1>It works!</h1>

<h1>smarty virtual host</h1>

<h1>c:\www\smarty</h1>

<?php


// NOTE: (for ?nix - Smarty has a capital 'S'
/************
require_once('c:/utils/php/smarty-3.1.16/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('./templates/');
$smarty->setCompileDir('./templates_c/');
$smarty->setConfigDir('./configs/');
$smarty->setCacheDir('./cache/');
*************************/
require_once('includes/class.SmartyExtended.php');

$smarty = new SmartyExtended();

$smarty->assign('name','Chris');

//** un-comment the following line to show the debug console
$smarty->debugging = true;

print("========= Start Smarty generated content =========\n");

$smarty->display('index.tpl');

print("========= End Smarty generated content   =========<br>\n");
?>

</body>

</html>