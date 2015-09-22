<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../classes/registry.php');
require_once('../classes/configuration.php');
require_once('../classes/urlhandler.php');
require_once('../classes/controller.php');

//Registy create instance of
$registry = Registry::instance();

//Database
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$conn="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($conn,$db->getUserName(),$db->getPassword()); 
$pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
$registry->set('pdo', $pdo);
$dbHost =  $registry->get('pdo');

//Url handling
$registry->set('urlhandler', new UrlHandler($dbHost));
$urlhandler = $registry->get('urlhandler');
$urlhandler->routeRequest(); ?>