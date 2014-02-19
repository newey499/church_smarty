{* Smarty *}

{* ****************************************

filename: columnRight.tpl

******************************************* *}


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




