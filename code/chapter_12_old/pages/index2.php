<?php 
session_start();
require_once('../classes/urlrewriter.php');
require_once('../classes/layout.php');

$urlhandler =  new UrlRewriter();
echo "SERVER: " . $urlhandler->server . "<br>";
echo "CATEGORY: " . $urlhandler->category . "<br>";
echo "ITEM: " . $urlhandler->item . "<br>";
?>