{* Smarty *}

{*****************************************

filename: mp3Talks.tpl


	const QRY_COLS = "id, filename, dateperformed, 
		            DATE_FORMAT(dateperformed, '%b %D %Y') AS datedisplay,
								DATEDIFF(CURRENT_DATE(), lastupdated) AS days_old,
								series, biblebook, bibleref, title, preacher, description,
								groupno, itemno";


******************************************}

<h4>
  Sermons and Talks (Audio)
</h4>

<p>
To play the MP3's in a browser click on the link.
<br>
To download the MP3's right click on the link and use the "Save link as" option.	
</p>

<table style="width: 100%;">

	<tr>
		<td>
			<h2>Recent</h2>
		</td>
	</tr>	

	{get_sermons_talks fetch="RECENT" days=#daysToBeConsideredNew# out="oSermonsTalks"}	

	{foreach $oSermonsTalks->aStMp3Items as $oStMp3Item}

		{include 'common/mp3TalksItem.tpl'  aRec=$oStMp3Item->aRec}	

	{/foreach}	

	{get_sermons_talks fetch="ALL" out="oSermonsTalks"}

	{$groupno=''}

	{foreach $oSermonsTalks->aStMp3Items as $oStMp3Item}

		{if $groupno <> $oStMp3Item->aRec.groupno}
			{$groupno=$oStMp3Item->aRec.groupno}
			<tr>
				<td>
					<h2>{$oStMp3Item->aRec.series}</h2>
				</td>
			</tr>
		{/if}

		{include 'common/mp3TalksItem.tpl'  aRec=$oStMp3Item->aRec}	

	{/foreach}	
	
</table>


