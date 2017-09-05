<?php
/* Set up variables */
$serverName   = "mariadb-087.wc1.dfw3.stabletransit.com";
$userName     = "387732_testuser3";
$password     = "phpbo^ok3belonG_3r"; 
$dbName       = "387732_phpbook3";

/* Connect using PDO */
try {
  $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch (PDOException $error) {
  echo 'Error message: ' . $error->getMessage() . '<br>';
  echo 'File name: ' . $error->getFile() . '<br>';
  echo 'Line number: ' . $error->getLine() . '<br>';
}
?>