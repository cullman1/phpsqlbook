<?php
  session_start();
  if (isset($_SESSION["visited"])) {
    $greeting = 'Welcome back';
  } else {
    $_SESSION["visited"] = TRUE;
    $greeting = 'Hello';
  }
?>
<h1><?= $greeting; ?></h1>