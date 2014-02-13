<?php
/******************************************

Chris Newey

04 - June - 2008

Completely rewrite:

ISP has rebuilt PHP to disable various system functions which breaks
the phpMailer class which was previously used to generate mail.

Quick and dirty fix to use the PHP mail function instead.

03/12/08 CDN HTML code to build a link
         NOTE: EVERYTHING in lower case
<form action="index.php?displaypage=mailform.php" method="post">
<input type="hidden" name="emailrecipient" 
value="office@christchurchlye.org.uk">
<input type="submit" value="Email">
</form>



*******************************************/
?>



<?php
require_once("genlib.php");
require_once("dbconnectparms.php");
?>	




<br />

<?php

	// Program Entry Point - Designed to be embedded in index.php

	// If $_POST['sendemail']) is set then this page is being
	// called by itself after an email form has been filled in
	
		
	if (isset($_POST['sendemail']))
	{ 
		sendEmailFromUser($_POST['emailrecipient']);	
	}
	else
	{
		// if $_POST['emailrecipient'] isn't present then look to see if 
		// $_GET['mailTo'] is set and use that
		if (isset($_POST['emailrecipient']))
		{ 		
			displayEmailForm($_POST['emailrecipient']);
		}
		else
		{
			if (isset($_GET['mailTo']))
			{
				displayEmailForm($_GET['mailTo']);
			}
			else
			{
				die("XX No Email Recipient Provided to send email to<br />\n");
			}
		}
	}
	return;
?>

<?php

function sendEmailFromUser($recipient)
{

	if (isset($_POST['sendemail']))
	{
		if (! ($isValidEmail = validateEmailForm()) )
		{
			// Validation Failed - redisplay form with error messages
			displayEmailForm($_POST['emailrecipient']);
		}
		else		
		{

			$headers = 'From: ' . $_POST['emailreplyto1']  . "\r\n" .
                 'Reply-To: ' . $_POST['emailreplyto1'] . "\r\n";
	

			if (mail(	$_POST['emailrecipient'],
							  $_POST['emailsubject'],
								$_POST['emailtext'],
								$headers))
			{
				echo "<h2>Mail Sent ok</h2> \n";
				echo "<br /> \n";
				echo "<br /> \n";				
			}
			else
			{
				echo "<h2>Message was not sent</h2>\n";
				echo "Mailer Error: " . $oMail->ErrorInfo . "<br /> \n";
				echo "<br /> \n";
				echo "To " . $_POST['emailrecipient'];
				echo "<br /> \n";
				echo "Subject " . $_POST['emailsubject'];
				echo "<br /> \n";
				echo "message " . $_POST['emailtext'];
				echo "<br /> \n";							
				echo "Headers " . $headers;
				echo "<br /> \n";	
				echo "<br /> \n";	
			}


		
			$_POST = array();
		
			return;
		}

	}


	return;
	
}	

?>



<?php
// ==================================================
function validateEmailForm()
{
	$isValidEmail = true;

	
	if ( empty($_POST['emailrecipient']) )
	{
		$isValidEmail = false;
		dispError("Email Recipient Required <br /> \n", true);
	}
	
	if ( empty($_POST['emailsubject']) )
	{
		$isValidEmail = false;
		dispError("Email Subject Required <br /> \n", true);
	}		
	
	if ( empty($_POST['emailreplyto1']) )
	{
		$isValidEmail = false;
		dispError("Email Reply Address Required <br /> \n", true);
	}				
	
	if ( empty($_POST['emailreplyto2']) )
	{
		$isValidEmail = false;
		dispError("Confirmation of Email Reply Address Required <br /> \n", true);
	}					
	
	
	if ( $isValidEmail && ! ($_POST['emailreplyto1'] == $_POST['emailreplyto2']) )
	{
		$isValidEmail = false;
		dispError("Email Reply Address and confirmation are different<br /> \n", true);
	}						

	$_POST['emailtext'] = trim($_POST['emailtext']);
	if ( empty($_POST['emailtext']) )
	{
		$isValidEmail = false;
		dispError("Email Text Required <br /> \n", true);
	}			

	if (! $isValidEmail)
	{
		print("<br />\n");
	}
	
	return $isValidEmail;
}

// ==================================================
?>



<?php
// ==================================================
function displayEmailForm($recipient)
{
?>

 <h2>Send Email</h2>

<!-- This extra pointless garbage is needed to get IE out of the crap -->
<!-- Without it the church image in the centre panel gets trampled on -->
<!-- Note that Firefox, Opera, Safari, and Google Chrome do NOT have a frigging problem -->
<!--[if IE ]>
	<div>
	<br />
	<br />
	<br />
	<br />
	<br />
	</div>
<![endif]-->




 <br /> 


 <form action="index.php?displaypage=mailform.php" method="post" class="emailForm" >

  <input type="hidden" name="sendemail" value="sendemail" > 

	<table border="0" align="left">
	
	<colgroup width="150">
	<colgroup width="*">
	

	<tbody> 
 
 		<tr>
	    <td>
  	  To &nbsp;
  	  </td>

  	  <td> 
  	  <span class="emailFormRecipient" >
  	  <input type="text" size="50" name="emailrecipient" value="<?php print($recipient); ?>"
  	         readonly >  
  	  </span>
  	  </td>
		</tr>

    <tr>
	    <td>
	    Subject &nbsp;
			</td>
	    <td>
	    <input type="text" size="50" name="emailsubject" value="<?php print($_POST['emailsubject']); ?>">
			</td>
		</tr>
    
    <tr>
	    <td>
	    Your email &nbsp;
	    </td>
			<td>
	    <input type="text" size="50" name="emailreplyto1" value="<?php print($_POST['emailreplyto1']); ?>" >  
			</td>
		</tr>

    
    <tr>
	    <td>
	    Confirm email &nbsp;
	    </td>
			<td>
	    <input type="text" size="50" name="emailreplyto2" value="<?php print($_POST['emailreplyto2']); ?>" >  
			</td>
		</tr>

 		<tr>
	 		<td colspan="2">
 			Content (1000 Characters Maximum)    
  		</td>
		</tr>
      
 		<tr>
	 		<td colspan="2">
	    <textarea name="emailtext" rows="20" cols="75" maxlength="1000" ><?php print($_POST['emailtext']); ?></textarea>
			</td>
		</tr>

	 <tr>
	   <td>
		 <input type="submit" value="Send"> 
		</td>
		<td>
		<input type="reset">
		</td>
	</tr>        
   
 	</tbody>
 
 	</table>   
 	 
 </form>


 
<?php
return;
}

// ==================================================
?>


