{* Smarty *}

{include 'header.tpl' nocache}
{include 'bodyStart.tpl' nocache}
body

<h1>It works!</h1>

<h1>smarty virtual host</h1>

<h1>c:\www\smarty</h1>

<p>
App Name [{$app_name}]
</p>

<p>
Hello {$name}, welcome to Smarty!
</p>


{include 'bodyEnd.tpl' nocache}
{include 'footer.tpl' nocache}