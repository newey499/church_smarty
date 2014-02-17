{* Smarty *}

{*****************************************

filename: whatsOnCalendar.tpl

******************************************}

<br />


<h2>{$pageTitle}</h2>

<br>

<b>Select Month </b>

{cbx_months months=14}

<br>
<br>

<p>

<table style="width:70%;">

	<tr>

	<td style="width:20%;">
			<a href="index.php?id={#primary_key_menu_weekly_church_services#}">
			Weekly Church Services
			</a>
	</td>

	<td style="width:20%;">
		<a href="index.php?id={#primary_key_menu_forthcoming_events#}">
		Forthcoming Events
		</a>
	</td>

	</tr>

</table>


</p>

<br>

<table class="calendar">

	<tr class="calendar">
		<th  class="calendar" >
			<b>
			Monday
			</b>
		</th>
		<th  class="calendar" >
			<b>
			Tuesday
			</b>
		</th>
		<th  class="calendar" >
			<b>
			Wednesday
			</b>
		</th>
		<th  class="calendar" >
			<b>
			Thursday
			</b>
		</th>
		<th  class="calendar" >
			<b>
			Friday
			</b>
		</th>
		<th  class="calendar" >
			<b>
			Saturday
			</b>
		</th>
		<th  class="calendar" >
			<b>
			Sunday
			</b>
		</th>
	</tr>

</table>


</p>

<br>


{create_calendar_table month=$month year=$year out='oCalendar'}

<h4>
	Month [{$oCalendar->month}]
	<br>
	Year [{$oCalendar->year}]
	
</h4>



