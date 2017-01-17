<?php 
session_start();

require_once('../classes/urlrewriter.php');
$urlparts =  new UrlRewriter();
require_once('../classes/registry.php');
require_once('../classes/database.php');
$registry = Registry::instance();	
$registry->set('database', new Database());
require_once('../classes/layout.php');
$layout = new Layout($urlparts->server, $urlparts->category, $urlparts->item);
?>