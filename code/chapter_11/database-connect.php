<?php
 ini_set('display_errors', '0');

/* Set up database connection variables */
$serverName   = "127.0.0.1";
$userName     = "root";
$password     = "";
$dbName       = "cms";

/* Connect using PDO */
try {
  $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE,     PDO::ERRMODE_EXCEPTION); 
}

catch (Exception $e) {
  echo "Line: ".       $e->getLine()."<br/>";
  echo "Message: ".    $e->getMessage()."<br/>";
  echo "Error Code: ". $e->getCode()."<br/>";
  echo "File Name: ".  $e->getFile()."<br/>";
}
?>