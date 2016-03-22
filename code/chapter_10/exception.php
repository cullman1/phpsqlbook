<?php
ini_set('display_errors', TRUE);
function connect_db($serverName, $dbName, $userName, $password) {
try {
 $dbHost = new PDO("mysql:host=$serverName;dbname=$dbName",$userName,$password);
 $dbHost->setAttribute(PDO::ATTR_ERRMODE, 
 PDO::ERRMODE_EXCEPTION); 
 return $dbHost;
}
catch (Exception $e) {
       echo $e->getLine()."<br/>";
    echo $e->getMessage()."<br/>";
    echo $e->getCode()."<br/>";
    echo $e->getFile()."<br/>";
 }
}


$connection =connect_db("","","","");
?>