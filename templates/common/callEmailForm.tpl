{* Smarty *}

{********************************************************
	filename: callEmailForm.tpl
	
	include example: {include 'common/callEmailForm.tpl' emailrecipient='gloria.burrows@christchurchlye.org.uk'}

*********************************************************}

<p>

	<form action="{$smarty.server.SCRIPT_NAME}?id={#primary_key_menu_email_row_id#}" method="post">

	<input type="hidden" name="emailrecipient"
				 value="{$emailrecipient}">

	<input type="hidden" name="calling_url"
	value="{$smarty.server.SCRIPT_NAME}?id={$primary_key_menu_id}">
	
	<input type="hidden" name="calling_page_title"
	value="{$pageTitle}">
	
	<input type="hidden" name="newemail" value = "YES">

	{* blank values for new $_POST variables *}
	<input type="hidden" name="emailsubject" value = "">
	<input type="hidden" name="emailreplyto1" value = "">
	<input type="hidden" name="emailreplyto2" value = "">
	<input type="hidden" name="emailtext" value = "">

	<input type="submit" value="Email">		
	
	</form>

</p>


