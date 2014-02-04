{* Smarty *}

<div id="footer">
<!-- ========================================================================== -->
<!--                          Start Footer Content Section                      -->
<!-- ========================================================================== -->

<div style="float:right; width:120px;" >
	<div style="color:red;">
		<b>
		<!-- ----------------------
		<?php
			print "Last Updated <br />\n";
			print getLastUpdateTimestamp();
		?>
		--------------------------- -->
		</b>
	</div>
</div>


{* use the date_format modifier to show current date and time *}
{* {$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'} *}
Copyright &copy; 2004 - {$smarty.now|date_format:'%Y'}

Christ Church Lye &amp; Stambermill Parochial Church Council

<br />

<a href="http://www.charity-commission.gov.uk/Showcharity/RegisterOfCharities/CharityWithoutPartB.aspx?RegisteredCharityNumber=1134648&SubsidiaryNumber=0">Registered Charity No. 1134648</a>



<a href="index.php?displaypage=mailform.php&mailTo=Office@christchurchlye.org.uk" >Church Office</a>
|
<a href="index.php?displaypage=mailform.php&mailTo=Simon.Falshaw@christchurchlye.org.uk" >Priest in Charge</a>
|
<a href="index.php?displaypage=mailform.php&mailTo=KeithStroyde@hotmail.co.uk" >Youth &amp; Community Worker</a>
|
<a href="index.php?displaypage=mailform.php&mailTo=Gloria.Burrows@christchurchlye.org.uk" >Church Secretary</a>
|
<a href="index.php?displaypage=mailform.php&mailTo=Webmaster@christchurchlye.org.uk" >Webmaster</a>

<!-- -----------------
|
<a href="http://rest.christchurchlye.org.uk/">REST Service</a>
---------------------- -->

<!-- ========================================================================== -->
<!--                            End Footer Content Section                      -->
<!-- ========================================================================== -->
</div> <!-- end div id="footer"> -->