<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../classes/registry.php');
require_once('../classes/configuration.php');
require_once('../classes/url-handler.php');
require_once('../classes/page.php');

//Registy create instance of
$registry = Registry::instance();

//Database
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$pdoString="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($pdoString, $db->getUserName(), $db->getPassword()); 
$registry->set('pdo', $pdo);
$dbHost =  $registry->get('pdo');

//Url handling
$registry->set('urlhandler', new UrlHandler());
$urlhandler = $registry->get('urlhandler');
$controller = $urlhandler->getController();
$page = $urlhandler->getAction();
$parameters = $urlhandler->getParameters();

//Assemble Template
$registry->set('page', new Page($controller,$page,$parameters, $dbHost));
$page =  $registry->get('page');
$page->getHeader($urlhandler->getController());
$menu = $page->getMenu();
$menu->getMenuStyle();
$menu->getMenuTemplate();
$page->getContent();
$page->getFooter($urlhandler->getController());
?>