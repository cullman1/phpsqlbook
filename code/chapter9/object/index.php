<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../classes/registry.php');
require_once('../classes/configuration.php');
require_once('../classes/url-handler.php');
require_once('../classes/db-handler.php');
require_once('../classes/controller.php');

//Registy create instance of
$registry = Registry::instance();

//Database
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$pdoString="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($pdoString, $db->getUserName(), $db->getPassword()); 
$pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
$registry->set('pdo', $pdo);
$dbHost =  $registry->get('pdo');

//Url handling
$registry->set('urlhandler', new UrlHandler($dbHost));
$urlhandler = $registry->get('urlhandler');
$controller = $urlhandler->getController();
$page = $urlhandler->getAction();
$parameters = $urlhandler->getParameters();

//Assemble Template
$registry->set('Controller', new Controller(array('Search'), $controller, $page, $parameters, $dbHost));
$controller = $registry->get('Controller');
$controller->getPart("header");
//$controller->getSearch();
$controller->getPart("menu");
$controller->getContent();
$controller->getPart("footer");
?>