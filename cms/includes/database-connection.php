<?php
$serverName   = "127.0.0.1";
$userName     = "root";
$password     = ""; 
$dbName       = "cms";
$GLOBALS['connection'] = new PDO("mysql:host=127.0.0.1;dbname=cms", $userName, $password);
$GLOBALS['connection']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
?>