<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();

require_once('/cms/includes/class_lib.php');
$urlparts =  new UrlRewriter();
$layout = new Layout($urlparts->server, $urlparts->category, $urlparts->item);
?>