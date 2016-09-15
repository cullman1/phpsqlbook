<?php

$serverName = "127.0.0.1";
$userName = "root";
$password = ""; 
$databaseName = "cms";
$dbName       = "cms";

$GLOBALS["SMTPHost"] = "secure.emailsrvr.com";
$GLOBALS["Username"] = "chris@deciphered.com"; //"test@deciphered.com";  	// username
$GLOBALS["Password"] = "CU_Dec23c58y1"; //"Trecarne_PL145BS"; 	



/* Connect using PDO */
try {
  $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $error) {
  echo 'Error message: ' . $error->getMessage() . '<br>';
  echo 'File name: ' . $error->getFile() . '<br>';
  echo 'Line number: ' . $error->getLine() . '<br>';
}
?>