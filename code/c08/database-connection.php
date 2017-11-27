<?php
  ini_set('display_errors', TRUE);                         // Turn on errors
  error_reporting(E_ALL);                                  // Show all errors

  $server   = '207.246.241.90';                                 // DSN information
  $database = '387732_phpbook3';
  $port     = '3306';         // XAMPP usually set to 3306 MAMP usually set to 8889
  $user     = '387732_testuser3';
  $password = 'phpbo^ok3belonG_3r'; 

  try {                                                     // Try to connect 
    $pdo = new PDO("mysql:host=$server;dbname=$database;charset=utf8mb4;", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
  }                                                         // Display an error message
  catch (PDOException $error) {
    echo 'Error message: ' . $error->getMessage() . '<br>';
    echo 'File name: '     . $error->getFile()    . '<br>';
    echo 'Line number: '   . $error->getLine()    . '<br>';
  }

  /*$database_config = array (
    'dsn' => 'mysql:host=localhost:3306;dbname=phpbook4;charset=utf8mb4',
    'username' => 'root',
    'password' => ''
);
$database_config = array (
    'dsn' => 'mysql:host=207.246.241.90;dbname=387732_phpbook3;charset=utf8mb4',
    'username' => '387732_testuser3',
    'password' => 'phpbo^ok3belonG_3r'
);*/