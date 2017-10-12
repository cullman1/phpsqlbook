<?php
$serverName   = "mariadb-087.wc1.dfw3.stabletransit.com";
$userName     = "387732_testuser3";
$password     = "phpbo^ok3belonG_3r"; 
$dbName       = "387732_phpbook3";

$GLOBALS['connection'] = new PDO("mysql:host=mariadb-087.wc1.dfw3.stabletransit.com;dbname=387732_phpbook3", $userName, $password);
$GLOBALS['connection']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
?>