{* Smarty *}

{*****************************************

filename: whatsOnCalendar.tpl

******************************************}

<br />


<h2>{$pageTitle}</h2>

<br>

<b>Select Month </b>

{cbx_months months=3}

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



<br>


{create_calendar_table month=$month year=$year out='oCalendar'}

{* ****************************************
<h4>
	Month [{$oCalendar->month}]
	<br>
	Year [{$oCalendar->year}]
	<br>
	row_count [{$oCalendar->row_count}]
	<br>
	start of month [{$oCalendar->startOfMonth}]
	<br>	
	startOfMonthDayOfWeek_int [{$oCalendar->startOfMonthDayOfWeek_int}]
	<br>	
	startOfMonthDayOfWeek_str [{$oCalendar->startOfMonthDayOfWeek_str}]	
	<br>
	startOfCalendarDayOfWeek_int [{$oCalendar->startOfCalendarDayOfWeek_int}]
	<br>	
	startOfCalendarDayOfWeek_str [{$oCalendar->startOfCalendarDayOfWeek_str}]	
	<br>
	endOfCalendarDayOfWeek_int [{$oCalendar->endOfCalendarDayOfWeek_int}]
	<br>	
	endOfCalendarDayOfWeek_str [{$oCalendar->endOfCalendarDayOfWeek_str}]	
	<br>	
</h4>
********************************************** *}

<p>

<table class="calendar">

	{foreach $oCalendar->aWeeks as $oCalendarWeek }

		{include file='common/whatsOnCalendarWeekDaysHeader.tpl'}				

		<tr class="calendar">
		{foreach $oCalendarWeek->aDays as $oCalendarDay}
			
			{if ($oCalendarDay->day_in_requested_month)}
				{assign var="calendar_class" value="calendar"}
			{else}
				{assign var="calendar_class" value="calendardim"}				
			{/if}
			
			<td class="{$calendar_class}">
				<div style="text-align: center;">
					<b>
					{$oCalendarDay->date_unix|date_format:"%d/%m/%Y"}
					</b>
					<hr>
					{if ($smarty.now|date_format:'%Y-%m-%d') == 
								$oCalendarDay->date_unix|date_format:'%Y-%m-%d'}
								<b>
								<span style="color:red;">Today</span>
								</b>
					{/if}
				</div>
				<br>
				{foreach $oCalendarDay->aEvents as $aEvent}
					<br>
					{$aEvent.eventtime|date_format:"%I:%M %p"}				
					<br>
					{if $calendar_class == "calendar"}
						<a href="{$aEvent.linkurl}">{$aEvent.eventname}</a>
					{else}
						<b>
						{$aEvent.eventname}							
						</b>
					{/if}
					<br>					
				{/foreach}
					
				
			</td>			
			
		{/foreach}
		</tr>

	
	{/foreach}

</table>

</p>





