<?php
require_once('../classes/registry.php');

$registry = Registry::getInstance();

//Database
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile')->getSection('db');
$pdoString="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($pdoString, $db->getUserName(), $db->getPassword()); 
$registry->set('pdo', $pdo);

//Url handling
$registry->set('urlhandler', new UrlHandler());

//Assemble Template
$registry->set('urlhandler', new Page());

?>