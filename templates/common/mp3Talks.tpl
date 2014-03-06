{* Smarty *}

{*****************************************

filename: mp3Talks.tpl

******************************************}

<h4>
  Sermons and Talks (Audio)
</h4>

<p>
To play the MP3's in a browser click on the link.
<br>
To download the MP3's right click on the link and use the "Save link as" option.	
</p>

<br>

<h4>Recent - last {#daysToBeConsideredNew#} days</h4>

{get_sermons_talks fetch="RECENT" days=#daysToBeConsideredNew# out="oSermonsTalks"}

{foreach $oSermonsTalks->aStMp3Items as $oStMp3Item}
	
	{$oStMp3Item->aRec.title}	<br>
	
{/foreach}	