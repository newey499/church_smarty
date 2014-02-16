{* Smarty *}

{*****************************************

filename: forthcomingEvents.tpl

******************************************}
<h2>{$pageTitle}</h2>


<h4>
Diary of Forthcoming Events
</h4>

<p>

<b>
For further information contact the Church Secretary
<br />
Gloria Burrows
<br />
01384 - 894948
<br >

<p>
{include 'common/callEmailForm.tpl' 
	emailrecipient='office@christchurchlye.org.uk'}
</p>


or use our RSS Feed.
&nbsp;&nbsp;

<img	src="images/feed-icon-14x14.png"
      alt="RSS Feed of Christ Church Forthcoming Events"
  		onclick="location.href='http://www.christchurchlye.org.uk/rss.xml'"
			onmouseover="this.style.cursor='pointer'"
			title="RSS Feed of Christ Church Forthcoming Events"
			width="14" height="14" />


</b>

</p>

<p>

<table>

<tr>

	<td>
		<form name="showall" 
			  action="{$smarty.server.SCRIPT_NAME}?id={$primary_key_menu_id}" method="post">

			<input type="hidden" name="forthcomingeventsearch"
			value="">
			<input type="submit" value="Show All Events">
		</form>
	</td>

	<td>


		<form name="input"
			  action="{$smarty.server.SCRIPT_NAME}?id={$primary_key_menu_id}" method="post">

			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;

			<input type="text"
		       name="forthcomingeventsearch"
					 value=""
		       width="1200"
		       maxlength="120">

			<input type="submit" value="Search Events">

		</form>
	</td>

</tr>

</table>

</p>

{get_forthcoming_events out="oForthcomingEvents"}


{foreach $oForthcomingEvents->aEvents as $aEvent}

		<div id='forthcomingEventTitle' >
			{$aEvent.eventname}

			<br />
			{if $aEvent.eventTime == #FC_HIDE_TIME#} 

				{$aEvent.displayEventDate}

			{else}

				{$aEvent.displayEventDateTime}

			{/if}		

		</div>

		<br>
		
		<div id='forthcomingEventDescription'>
		{$aEvent.eventdesc}	
		</div>

		<hr>

		<table id='forthcomingEventContactPoints'>

			<tr>
				<td>
				Contact Points:				
				</td>

				<td>
				{$aEvent.contactname = $aEvent.eventname}	
				</td>

				<td>
				Phone:				
				</td>			

				<td>
				{$aEvent.contactphone}				
				</td>	

				<td>
				{assign var='emailrecipient' value=$aEvent.contactemail|default:'office@christchurchlye.org.uk'}
				{assign var='emailsubject'	 value=$aEvent.eventname|default:''}
				{include 'common/callEmailForm.tpl'}
				</td>	

			</tr>


		</table>
	
{/foreach}


<p>

  <b>Forthcoming events for the Worcester Diocese</b> may be found in the
  Diocesan

  <a href="http://www.cofe-worcester.org.uk/AA/154">
  newsletter.
  </a>

  <br />
  The newsletter is stored on the Worcester Diocesan website in PDF format.
  You may need to download a copy of the

  <a href="http://www.adobe.com/downloads/">
  Adobe Reader
  </a>

 
  software or another pdf reader such as Foxit for
	<a href="http://foxitsoftware.com/Secure_PDF_Reader/">
  Windows
	</a>
	or 
	<a href="https://www.foxitsoftware.com/pdf/desklinux/">
  Linux
	</a>

  all of which are free.

</p>

<br>
<br>