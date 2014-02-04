{* Smarty *}

{include 'header.tpl' nocache}
{include 'bodyStart.tpl' nocache}

<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">

<h4>Centre Column</h4>

<h1>It works!</h1>

<h1>church_smarty virtual host</h1>

<h1>c:\www\church_smarty</h1>

<p>
App Name [{$app_name}]
</p>

<p>
Hello {$name}, welcome to Smarty!
</p>

</div>  <!-- END <div class="innertube"> -->
</div>  <!-- END <div class="contentcolumn"> -->
</div>  <!-- END <div class="contentwrapper"> -->



<div id="leftcolumn">
<div class="innertube">

<h4>Left Column</h4>

</div>  <!-- END <div class="innertube"> -->
</div>  <!-- END <div id="leftcolumn"> -->





<div id="rightcolumn">
<div class="innertube">

<h4>Right Column</h4>

</div>  <!-- END <div class="innertube"> -->
</div>  <!-- END <div id="rightcolumn"> -->



{include 'bodyEnd.tpl' nocache}
{include 'footer.tpl' nocache}