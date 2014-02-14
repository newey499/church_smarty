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
$oSmarty->assign('lastUpdatedDateTime', getLastUpdateTimestamp());

/**************
if (isset($_GET['id']))
{
	$oSmarty->assign('primaryKeyId', $_GET['id']);	
}
else 
{
	$oSmarty->assign('primaryKeyId', "Not Set");
}
****************/

if (isset($_GET['id']) && is_int((int) $_GET['id']))
{
	$id = $_GET['id'];
}
else 
{
	$id = "1";
}

print("<h1>id [" . $id . "]</h1>");
$oSmarty->assign('primary_key_menu_id', $id);

$row = Menu::getMenuItemContent($id);

/*******************
 * 
 * Hierarchy is:
 *  1) If we get here the the content is not an external website.
 *	2) If menus.smartytemplate is not empty read the contents of the file 
 *     and use as content.
 *  3) If menus.smartytemplate is empty read the contents of the menus.content column 
 *     and use as content.
 */

$template_dir = $oSmarty->getTemplateDir();
var_dump($template_dir);

if (empty($row['smartytemplate']))
{
	$oSmarty->assign('centreColumnContent', $row['content']);	
}
else 
{
	if (isSmartyTemplateFile($row['smartytemplate']))
	{
			if (! file_exists($row['smartytemplate']))
			{
				$content = "<h4>Smarty template file [" . $row['smartytemplate'] . "] not found.</h4>";	
			}
			else 
			{
				$content = file_get_contents($row['smartytemplate']);
				if ($content === false)
				{
					$content = "<h4>Smarty template file [" . $row['smartytemplate'] . "] not found.</h4>";		
				}	
			}
			
			$oSmarty->assign('centreColumnContent', $content);					
	}
	
}



$oSmarty->assign('pageTitle', $row['prompt']);
//$oSmarty->assign('calling_URL', 'index.php?id=' . $id);
//require_once('php/header.php');

// ========= Start Smarty generated content =========
$oSmarty->display('index.tpl');
// ========= End Smarty generated content   =========

//require_once('php/footer.php');

?>
