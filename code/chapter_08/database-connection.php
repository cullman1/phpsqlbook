<?php
ini_set('display_errors', TRUE);                         // Turn on errors
error_reporting(E_ALL);                                  // Show all errors

$server   = '207.246.241.90';                                 // DSN information
$database = '387732_phpbook3';
$user     = '387732_testuser3';
$password = 'phpbo^ok3belonG_3r'; 

try {                                                     // Try to connect 
 $pdo = new PDO("mysql:host=$server;dbname=$database", $user, $password);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $error) {
 echo 'Error message: ' . $error->getMessage() . '<br>';
 echo 'File name: '     . $error->getFile()    . '<br>';
 echo 'Line number: '   . $error->getLine()    . '<br>';
}
