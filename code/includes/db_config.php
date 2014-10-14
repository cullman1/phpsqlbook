<?php
/* Connect using PDO . */
try
{
    $dbHost = new PDO("mysql:host=72.32.1.16;dbname=phpbook1", "testuser", 
    "PHPBookPassword");
    $dbHost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch (PDOException $e)
{
    echo $e->getMessage();
}
?>