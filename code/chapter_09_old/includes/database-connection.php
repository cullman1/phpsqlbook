<?php
/* Set up variables
$serverName   = "localhost:8889";
$userName     = "phpbook";
$password     = "testuser"; 
$dbName       = "phpbook1";
 */
/* Set up variables */
$serverName   = "172.99.96.46";
$userName     = "387732_phpbook1";
$password     = "F8sk3j32j2fslsd0"; 
$dbName       = "387732_phpbook1";

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