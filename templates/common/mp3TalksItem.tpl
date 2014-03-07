{* Smarty *}

{*****************************************

filename: mp3TalksItem.tpl

$aRec is passed as a parameter to this template and
contains an assoc array of the sermonstalks table row.

	const QRY_COLS = "id, filename, dateperformed, 
		            DATE_FORMAT(dateperformed, '%b %D %Y') AS datedisplay,
								DATEDIFF(CURRENT_DATE(), lastupdated) AS days_old,
								series, biblebook, bibleref, title, preacher, description,
								groupno, itemno";

******************************************}

<tr>
	<td style="padding-right: 5px;">
		<b>{$aRec.bibleref}</b>
	</td>

	<td style="padding-right: 5px;">
		<a href="media/mp3/{$aRec.filename}">{$aRec.title}</a>
	</td>

	<td style="padding-right: 5px;">
		{$aRec.datedisplay}
	</td>
	
	<td style="padding-right: 5px;">
		{$aRec.preacher}		
		<br>
	</td>
</tr>