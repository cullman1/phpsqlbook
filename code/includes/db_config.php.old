<?php

/* Include passwords and login details */
require_once('login-variables.php');

/* Connect using PDO . */
try
{
    $dbHost = new PDO("mysql:host=$serverName;
                        dbname=$databaseName", 
                        $userName, 
                        $password);
    $dbHost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch (PDOException $e)
{
    echo $e->getMessage();
}
?>