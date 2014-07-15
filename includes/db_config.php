<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

/* Include passwords and login details */
require_once('login-variables.php');
  
/* Connect using PDO . */
try
{
    $dbHost = new PDO("mysql:host=$serverName;dbname=$dbname", $userName, $password);
}
catch (PDOException $e)
{
    echo $e->getMessage();
}
?>