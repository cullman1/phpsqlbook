<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  session_start();
  if (isset($_SESSION["visited"])) {
    $greeting = 'Welcome back';
  } else {
    $_SESSION["visited"] = TRUE;
    $greeting = 'Hello';
  }
?>
<h1><?= $greeting; ?></h1>