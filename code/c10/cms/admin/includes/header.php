<?php
require_once dirname(__DIR__) .'/../config.php';
$userManager->redirectNonAdmin();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/css/styles.css" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="<?= ROOT ?>"><?= $site_name ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav">
          <li><a href="articles.php" class="nav-item nav-link">articles</a></li>
          <li><a href="categories.php" class="nav-item nav-link">categories</a></li>
          <li><a href="users.php" class="nav-item nav-link">users</a></li>
        </ul>
        <ul class="navbar-nav user-nav">
          <?php if ($is_logged_in) { ?>
            <li><a class="nav-item nav-link" href="<?= ROOT ?>users/<?=$_SESSION['seo_name']?>"><?= $_SESSION["name"] ?>'s profile</a></li>
            <li><a class="nav-item nav-link" href="<?= ROOT ?>users/logout.php">Logout</a></li>
          <?php  } else { ?>
            <li><a class="nav-item nav-link" href="<?= ROOT ?>users/login.php">Login</a></li>
          <?php } ?>
        </ul>
      </div>
    </nav>