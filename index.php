<?php 
session_start();

require_once('/code/chapter_12/includes/class_lib.php');
$urlparts =  new UrlRewriter();
$registry = Registry::instance();	
$registry->set('database', new Database());
$layout = new Layout($urlparts->server, 
                   $urlparts->category, $urlparts->item);
?>