<?php
ini_set('display_errors', TRUE);                         // Turn on errors
error_reporting(E_ALL);                                  // Show all errors

$server   = '127.0.0.1';                                 // DSN information
$database = 'cms';
$port     = '8889';
$user     = 'root';
$password = ''; 

try {                                                     // Try to connect 
 $pdo = new PDO("mysql:host=$server;dbname=$database;port=3306", $user, $password);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}                                                         // Display an error message
catch (PDOException $error) {
 echo 'Error message: ' . $error->getMessage() . '<br>';
 echo 'File name: '     . $error->getFile()    . '<br>';
 echo 'Line number: '   . $error->getLine()    . '<br>';
}