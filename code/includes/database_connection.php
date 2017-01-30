<?php
error_reporting(E_ALL & ~E_NOTICE);
$serverName = "127.0.0.1";
$userName = "root";
$password = ""; 
$databaseName = "cms";
$dbName       = "cms";

$GLOBALS["SMTPHost"] = "secure.emailsrvr.com";
$GLOBALS["Username"] = "placeholder@deciphered.com"; //"test@deciphered.com";  	// username
$GLOBALS["Password"] = "placeholder"; //"Trecarne_PL145BS"; 	



/* Connect using PDO */
try {
  $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
 // $connection->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true); Do it on query by query basis!
} catch (PDOException $error) {
  echo 'Error message: ' . $error->getMessage() . '<br>';
  echo 'File name: ' . $error->getFile() . '<br>';
  echo 'Line number: ' . $error->getLine() . '<br>';
   echo 'Line number: ' . var_dump($error->getTrace()) . '<br>';
}
?>