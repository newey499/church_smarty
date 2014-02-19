{* Smarty *}

{* ****************************************

filename: columnLeft.tpl

******************************************* *}


<div id="leftcolumn">
<div class="innertube">

<div>

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




