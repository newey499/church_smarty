{* Smarty *}


{include 'header.tpl' nocache}
{include 'bodyStart.tpl' nocache}

{config_load file="config/church_smarty.conf"}

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

<br>
<br>


{$centreColumnContent}


</div>  <!-- END <div class="innertube"> -->
</div>  <!-- END <div class="contentcolumn"> -->
</div>  <!-- END <div class="contentwrapper"> -->



<div id="leftcolumn">
<div class="innertube">

<div>

<h4>PrimaryKeyId [{$primaryKeyId}]</h4>

<img	class="churchtopleft" src="images/site/church003small.jpg"
            alt="Picture of Christ Church - Click for full size picture"
			onclick="location.href='images/orig/church003.jpg'"
			onmouseover="this.style.cursor='pointer'"
			title="Picture of Christ Church - Click for full size picture" />

</div>

<br />


{get_menu menu_side="LEFT" out="oMenuLeft"}

{foreach $oMenuLeft->aMenuGroups as $oMenuGroup}

	<span class="menutitle">
		{$oMenuGroup->prompt}
		<br>
	</span>
	
	{foreach $oMenuGroup->aMenuItems as $oMenuItem}
	
		{* $oMenuItem->prompt *}	

		{$oMenuItem->menuitemlink}		
	
		{if $oMenuItem->lastupdatedays <= #daysToBeConsideredNew#}	
			<span id="new">&nbsp; New</span>
		{/if}
		
		<br>
		
	{/foreach}
	
 
 
	<br>
		
{/foreach}



</div>  <!-- END <div class="innertube"> -->
</div>  <!-- END <div id="leftcolumn"> -->





<div id="rightcolumn">
<div class="innertube">

{get_menu menu_side="RIGHT" out="oMenuRight"}

{foreach $oMenuRight->aMenuGroups as $menuGroup}
	<span class="menutitle">
	{$menuGroup->prompt} <br>
	</span>
	
	{foreach $menuGroup->aMenuItems as $oMenuItem}
	
		{* $oMenuItem->prompt *}

		{$oMenuItem->menuitemlink}	
		
		{if $oMenuItem->lastupdatedays <= #daysToBeConsideredNew#}
		
			<span id="new">&nbsp; New</span>
			
		{/if}
		
		<br>
		
	{/foreach}
	
	<br>
		
{/foreach}



</div>  <!-- END <div class="innertube"> -->
</div>  <!-- END <div id="rightcolumn"> -->



{include 'bodyEnd.tpl' nocache}
{include 'footer.tpl' nocache}


