{* Smarty *}

{* ****************************************

filename: columnContent.tpl

******************************************* *}


<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">

<div class="menutop">
<a href="index.php" class="menuitem" >Home</a>
</div>

<div class="churchcenter" >

<img	class="churchcenterimg" src="images/site/churchfrontwarmem.jpg"
            alt="Picture of Christ Church - Click for full size picture"
			onclick="location.href='images/site/churchfrontwarmem.jpg'"
			onmouseover="this.style.cursor='pointer'"
			title="Picture of Christ Church - Click for full size picture" />

</div>

{eval var=$centreColumnContent}

</div>  <!-- END <div class="innertube"> -->
</div>  <!-- END <div class="contentcolumn"> -->
</div>  <!-- END <div class="contentwrapper"> -->




