<?php 
session_start();
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../classes/registry.php');
require_once('../classes/database.php');
require_once('../classes/urlrewriter.php');
require_once('../classes/layout.php');

//Registy create instance of
$registry = Registry::instance();

//Store database object
$registry->set('database', new Database());
$database = $registry->get('database');  
$GLOBALS['connection'] = $database->connection;
//Url handling
$urlparts =  new UrlRewriter();
$layout = new Layout($urlparts->server,$urlparts->category,$urlparts->item);
?>