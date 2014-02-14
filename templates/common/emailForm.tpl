{* Smarty *}

{********************************************************
	filename: emailForm.tpl
	
*********************************************************}


<h2>Send Email</h2>

<p>
	<a href='{$smarty.post.calling_url}' >
		Return to {$smarty.post.calling_page_title}
	</a>	
</p>


<p>

{send_email input="EXAMPLE" out="oEmail"}

 <form action="{$smarty.server.SCRIPT_NAME}?id={#primary_key_menu_email_row_id#}"
           method="post">

	<input type="hidden" name="sendemail" value="sendemail" > 
	<input type="hidden" name="calling_url" value='{$smarty.post.calling_url}' > 

	<input type="hidden" name="calling_page_title"
	value="{$smarty.post.calling_page_title}">

	<table border="0" align="left">
	
	<colgroup width="150">
	<colgroup width="*">
	

	<tbody> 
 
 		<tr>
	    <td>
  	  To &nbsp;
  	  </td>

  	  <td> 
				<span id="emailFormRecipient">
					<input type="text" size="50" name="emailrecipient" 
								 value="{$smarty.post.emailrecipient}" readonly >  
				</span>	
  	  </td>
		</tr>

    <tr>
	    <td>
	    Subject &nbsp;
			</td>
	    <td>
	    <input type="text" size="50" name="emailsubject"
		value="{$smarty.post.emailsubject}"
			</td>
		</tr>
    
    <tr>
	    <td>
	    Your email &nbsp;
	    </td>
			<td>
	    <input type="text" size="50" name="emailreplyto1" 
				value="{$smarty.post.emailreplyto1}" >  
			</td>
		</tr>

    
    <tr>
	    <td>
	    Confirm email &nbsp;
	    </td>
			<td>
	    <input type="text" size="50" name="emailreplyto2" 
			value="{$smarty.post.emailreplyto2}" >  
			</td>
		</tr>

 		<tr>
	 		<td colspan="2">
 			Content (1000 Characters Maximum)    
  		</td>
		</tr>
      
 		<tr>
	 		<td colspan="2">
			<textarea name="emailtext" rows="20" cols="75" maxlength="1000"
			>{$smarty.post.emailtext}</textarea>
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
 	 
<br>
<br>

 </form>

</p>





 



