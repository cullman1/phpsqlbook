<?php
 ini_set('display_errors', '0');

/* Set up database connection variables */
$serverName   = "serverName";
$userName     = "userName";
$password     = "password";
$dbName       = "dbName";

/* Connect using PDO */
try {
  $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION); 
}

catch (PDOException $e) {
  echo $e->getLine()."<br/>";
  echo $e->getMessage()."<br/>";
  echo $e->getCode()."<br/>";
  echo $e->getFile()."<br/>";
}
?>