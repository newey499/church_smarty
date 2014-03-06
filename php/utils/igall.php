<?php

/* 
 * Move files for image gallery from Church website to Church_Smarty website
 * 
 * filename : igall.php
 * 
 */

class Jpg
{
	const DIR_FROM    = '/www/church/';
	const DIR_TO      = '/www/church_smarty/images/gallery/';
	const DIR_TO_ORIG = '/www/church_smarty/images/gallery/orig/';
	
	const SMARTY_TEXT = 'smarty.txt';
	
	protected $orig;
	protected $thumb;	
	protected $size;
	
	protected $origExists;
	protected $thumbExists;
	
	protected $fnameOrig;
	protected $fnameThumb;
	protected $copyOnlyOnce;
		
	function __construct($orig, $thumb, $size) 
	{
		$this->orig = Jpg::DIR_FROM . $orig;
		$this->thumb = Jpg::DIR_FROM . $thumb;
		$this->size  = $size;
		$this->fnameOrig  = Jpg::DIR_TO_ORIG . basename($this->orig);
		$this->fnameThumb = Jpg::DIR_TO . basename($this->thumb);		
		
		$this->origExists  = file_exists($this->orig);
		$this->thumbExists = file_exists($this->thumb);
		
		// If the original and the thumb point to the same file then
		// copy the thumb only.
		$this->copyOnlyOnce = ($this->orig == $this->thumb);
	}
	
	function __destruct() 
	{
	
	}
	
	public function exec()
	{
		print("public function exec()\n");			
		$this->moveFiles();
		$this->writeSmartyScript();
	}
	
	protected function moveFiles()
	{
		
		print("\tpublic function moveFiles()\n");		
		
		// bool rename ( string $oldname , string $newname);
		
		// If the original and the thumb point to the same file then
		// copy the thumb only.
		if ($this->copyOnlyOnce)
		{
			rename($this->thumb, $this->fnameThumb);
		}
		else 
	  {
			rename($this->thumb, $this->fnameThumb);
			rename($this->orig, $this->fnameOrig);			
		}
		
	}
	
	
	protected function writeSmartyScript()
	{
		print("\tpublic function writeSmartyScript()\n");
		$handle = fopen(Jpg::SMARTY_TEXT, "a+");
		
		if ($handle)
		{
			// {write_image_tag href="images/gallery/churchfrontwarmem.jpg" 
			//	 							  src="images/gallery/churchfrontwarmem.jpg"
			//							    size="24Kb"}				
			fwrite($handle, "\n{write_image_tag \n");
			fwrite($handle, "\thref='" . $this->fnameThumb . "'\n");	
			fwrite($handle, "\tsrc='" . $this->fnameOrig . "'\n");			
			fwrite($handle, "\tsize='" . $this->size . "'}\n\n");				
			fclose($handle);
		}
		
	}
	
};

print("igall.php\n");

unlink(Jpg::SMARTY_TEXT);

$aJpg = [];
  
 
$aJpg [] = new Jpg("jpgs/churchfrontwarmem.jpg", "jpgs/churchfrontwarmem.jpg", "24Kb");
$aJpg [] = new Jpg("jpgs/churchFront.jpg", "jpgs/churchFront.jpg", "5Kb");
$aJpg [] = new Jpg("jpgs/church003.jpg", "jpgs/church003.jpg", "5Kb");
$aJpg [] = new Jpg("jpgs/church002.jpg", "jpgs/thumbs/church002.jpg", "19Kb");
$aJpg [] = new Jpg("jpgs/church001.jpg", "jpgs/thumbs/church001.jpg", "5Kb");  
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin001.jpg", "jpgs/slide/churchwin/churchwin001.jpg", "3.4Mb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin002.jpg", "jpgs/slide/churchwin/churchwin002.jpg", "3.1Mb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin003.jpg", "jpgs/slide/churchwin/churchwin003.jpg", "1.4Mb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin004.jpg", "jpgs/slide/churchwin/churchwin004.jpg", "800Kb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin005.jpg", "jpgs/slide/churchwin/churchwin005.jpg", "160Kb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin006.jpg", "jpgs/slide/churchwin/churchwin006.jpg", "259Kb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin007.jpg", "jpgs/slide/churchwin/churchwin007.jpg", "193Kb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin008.jpg", "jpgs/slide/churchwin/churchwin008.jpg", "1.29Mb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin009.jpg", "jpgs/slide/churchwin/churchwin009.jpg", "111Kb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin010.jpg", "jpgs/slide/churchwin/churchwin010.jpg", "108.Kb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin011.jpg", "jpgs/slide/churchwin/churchwin011.jpg", "116Kb");
$aJpg [] = new Jpg("jpgs/slide/churchwin/orig/churchwin012.jpg", "jpgs/slide/churchwin/churchwin012.jpg", "58.Kb");
$aJpg [] = new Jpg("jpgs/slide/warmem/orig/warmem001.jpg", "jpgs/slide/warmem/warmem001.jpg", "2.2Mb");
$aJpg [] = new Jpg("jpgs/slide/warmem/orig/warmem002.jpg", "jpgs/slide/warmem/warmem002.jpg", "2.6Mb");
$aJpg [] = new Jpg("jpgs/slide/warmem/orig/warmem003.jpg", "jpgs/slide/warmem/warmem003.jpg", "4.3Mb");
$aJpg [] = new Jpg("jpgs/slide/warmem/orig/warmem004.jpg", "jpgs/slide/warmem/warmem004.jpg", "4.4Mb");
$aJpg [] = new Jpg("jpgs/slide/warmem/orig/warmem005.jpg", "jpgs/slide/warmem/warmem005.jpg", "4.3Mb");
$aJpg [] = new Jpg("jpgs/slide/warmem/orig/warmem006.jpg", "jpgs/slide/warmem/warmem006.jpg", "4.7Mb");
$aJpg [] = new Jpg("jpgs/slide/warmem/orig/warmem007.jpg", "jpgs/slide/warmem/warmem007.jpg", "5Mb");
$aJpg [] = new Jpg("jpgs/afghanistan-soldiers-poem.jpg", "jpgs/afghanistan-soldiers-poem.jpg", "120Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells-clean-2012-03-28-001.jpg", "jpgs/bells/bells-clean-2012-03-28-001.jpg", "436Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells-clean-2012-03-28-002.jpg", "jpgs/bells/bells-clean-2012-03-28-002.jpg", "440Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells001.jpg", "jpgs/bells/bells001.jpg", "205Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells002.jpg", "jpgs/bells/bells002.jpg", "131Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells003.jpg", "jpgs/bells/bells003.jpg", "138Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells004.jpg", "jpgs/bells/bells004.jpg", "196Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells005.jpg", "jpgs/bells/bells005.jpg", "110Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells006.jpg", "jpgs/bells/bells006.jpg", "225Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells007.jpg", "jpgs/bells/bells007.jpg", "670Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells008.jpg", "jpgs/bells/bells008.jpg", "735Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells009.jpg", "jpgs/bells/bells009.jpg", "615Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells010.jpg", "jpgs/bells/bells010.jpg", "400Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells011.jpg", "jpgs/bells/bells011.jpg", "550Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells012.jpg", "jpgs/bells/bells012.jpg", "430Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells013.jpg", "jpgs/bells/bells013.jpg", "525Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells014.jpg", "jpgs/bells/bells014.jpg", "635Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells015.jpg", "jpgs/bells/bells015.jpg", "800Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells016.jpg", "jpgs/bells/bells016.jpg", "650Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells017.jpg", "jpgs/bells/bells017.jpg", "715Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells018.jpg", "jpgs/bells/bells018.jpg", "645Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells019.jpg", "jpgs/bells/bells019.jpg", "380Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells020.jpg", "jpgs/bells/bells020.jpg", "590Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells021.jpg", "jpgs/bells/bells021.jpg", "670Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells022.jpg", "jpgs/bells/bells022.jpg", "705Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells023.jpg", "jpgs/bells/bells023.jpg", "700Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells024.jpg", "jpgs/bells/bells024.jpg", "405Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells025.jpg", "jpgs/bells/bells025.jpg", "390Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells026.jpg", "jpgs/bells/bells026.jpg", "600Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells027.jpg", "jpgs/bells/bells027.jpg", "605Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells028.jpg", "jpgs/bells/bells028.jpg", "600Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells029.jpg", "jpgs/bells/bells029.jpg", "540Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells030.jpg", "jpgs/bells/bells030.jpg", "545Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells031.jpg", "jpgs/bells/bells031.jpg", "505Kb");
$aJpg [] = new Jpg("jpgs/bells/orig/bells032.jpg", "jpgs/bells/bells032.jpg", "250Kb");


foreach ($aJpg as $oJpg)
{
	$oJpg->exec();
}

print_r($aJpg);

?>