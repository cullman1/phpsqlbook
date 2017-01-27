<?php 
session_start();

require_once('/classes/urlrewriter.php');
$urlparts =  new UrlRewriter();
echo "SERVER: " . $urlparts->server . "<br>";
echo "CATEGORY: " . $urlparts->category . "<br>";
echo "ITEM:" . $urlparts->item . "<br>";
?>