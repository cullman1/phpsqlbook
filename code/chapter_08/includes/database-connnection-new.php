<?php error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
/* Include passwords and login details */
require_once('login-variables.php');

/* Connect using PDO */
try {
  $connection = new PDO("mysql:host=$serverName;dbname=$databaseName", $userName, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch (PDOException $error) {
  echo 'Error message: ' . $error->getMessage() . '<br>';
  echo 'File name: ' . $error->getFile() . '<br>';
  echo 'Line number: ' . $error->getLine() . '<br>';
}
?>