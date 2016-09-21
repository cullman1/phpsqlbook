<style>
b {display: inline-block; width: 14em; }
</style>

<h1>DOMAIN &amp; FILE INFO</h1>
<b>Domain</b>
<?php echo $_SERVER['SERVER_NAME']; ?><br>
<b>Host header</b>
<?php echo $_SERVER['HTTP_HOST']; ?><br>
<b>URI for page</b>
<?php echo $_SERVER['SCRIPT_URI']; ?><br>
<b>Address of the script</b>
<?php echo $_SERVER['PHP_SELF']; ?><br>
<b>The actual script name and path</b>
<?php echo $_SERVER['SCRIPT_NAME']; ?><br>(can be different to address used to access it)<br>
<b>File path</b>
<?php echo $_SERVER['SCRIPT_FILENAME']; ?><br>


<h1>USER INFO</h1>
<b>IP adress</b>
<?php echo $_SERVER['REMOTE_ADDR'];	?><br>
<b>User agent</b>
<?php echo $_SERVER['HTTP_USER_AGENT']; ?><br>
<b>Referring page</b>
<?php echo $_SERVER['HTTP_REFERER']; ?><br>