<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

/* Include passwords and login details */
require_once('login-variables.php');

/* Connect using PDO . */
try
{
    $dbHost = new PDO("dblib:host=mssql2008R2.aspnethosting.co.uk: 14330;
                        dbname=eastcornwallharriers", 
                        "eastcorn_ech", 
                        "TVD!nner2");
    $dbHost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch (PDOException $e)
{
    echo $e->getMessage();
}
?>