<?php

/* 
 * Call from church_smarty directory for paths to work correctly
 * 
 * Eg.
 * cd \www\church_smarty
 * php\utils\fixRegularEventsTableLinkurlColumn.php
 * 
 * **************************************************************
 * 
 * 18-02-2014	CDN					Created
 *												Changes linkurl column inregularevents table to have correct links
 * 
 * 
 */

/*************************
ini_set('include_path',
		ini_get('include_path') . // Existing Path
		':.' .										// Current Directory
		':..'	.									  // Parent Directory
		':../..'	.								// Parent's Parent Directory
	  ':../../config'
	   );
************************/
echo "\n";
echo "Call from church_smarty directory for paths to work correctly\n";
echo "\n";
echo "Eg.\n";
echo "cd \www\church_smarty\n";
echo 'php\utils\fixRegularEventsTableLinkurlColumn.php' . "\n";
echo "\n";

require_once('php/class.MysqliExtended.php');

print("Start\n\n");

$oMysql = MysqliExtended::getInstance();

$qry = "select * from regularevents";
$res = false;

if (! $res = $oMysql->query($qry))
{
	die("Query [$qry] failed : " . $oMysql->error);
}

$i = 0;
while ($row = $res->fetch_assoc())
{
	print($row['eventname'] . "\n\t" . $row['linkurl'] . "\n");
	$pos = strpos($row['linkurl'], 'rowid=');
	if ($pos === false)
	{
		print('\trowid= NOT FOUND' .  "\n");		
	}
	else 
	{
		$id = substr($row['linkurl'], $pos + strlen('rowid='));
		print("\trowid= starts at $pos id=[$id]" . "\n");		
		$id_int = intval($id);
		$new_linkurl = "index.php?id=$id";
		print("\tnew_linkurl = [$new_linkurl]\n");
		$qry = " update regularevents " . 
					 " set linkurl = '" . $new_linkurl . "' " .
					 " where id = " . $row['id'];
		print("\tqry [" . $qry . "]\n\t");
		$resUpdate = false;
		if (! $resUpdate = $oMysql->query($qry))
		{ 
			print("Error - restore backup\n");
			die("Query [$qry] failed : " . $oMysql->error);
		}
	}

	$i++;
}
print("\n rows=$i\n");


print("\n\nEnd\n");





?>