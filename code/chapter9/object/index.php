<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../classes/registry.php');
require_once('../classes/configuration.php');
require_once('../classes/url-handler.php');
require_once('../classes/page.php');

$registry = Registry::instance();

//Database
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$pdoString="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($pdoString, $db->getUserName(), $db->getPassword()); 
$registry->set('pdo', $pdo);

//Url handling
$registry->set('urlhandler', new UrlHandler());

//Assemble Template

$registry->set('page', new Page());
$page =  $registry->get('page');
$page->getHeader();
$menu = $page->getMenu();
$menu->getMenuStyle();
$menu->getMenuTemplate();
$page->getFooter();
?>