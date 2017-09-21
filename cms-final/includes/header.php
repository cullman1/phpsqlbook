<?php
//$current_page    = basename($_SERVER["SCRIPT_FILENAME"], 'system-info.php');
$current_page    = $_SERVER['REQUEST_URI'];
$categoryManager = $cms->getCategoryManager();
$category_list   = $categoryManager->getNavigationCategories();

preg_match('/^\/cms-final\/([A-z0-9\-]+)/i', $current_page, $section);
$section = (isset($section[1]) ? $section[1] : '');

function highlight_nav($section, $url) {
  return (strtolower($section) == strtolower($url) ? 'active' : '');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $page_title ?></title>
    <meta name="description" value=" <?= $meta_description ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/css/styles.css" />
    <script src="https://use.fontawesome.com/3409469903.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="<?= ROOT ?>"><?= $site_name ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav">
          <?php
          foreach ($category_list as $category_link) {
           echo '<a href="' . ROOT . $category_link->seo_name . '" class="nav-item nav-link ' . highlight_nav($section, $category_link->name) . '">' . $category_link->name . '</a>';
          }
          ?>
          <a href="<?= ROOT ?>about" class="nav-item nav-link <?= highlight_nav($section, 'about')?>">About</a>
          <a href="<?= ROOT ?>contact" class="nav-item nav-link <?= highlight_nav($section, 'contact')?>">Contact</a>
        </ul>
        <ul class="navbar-nav user-nav">
        <?php if ($is_logged_in) { ?>
            <li><a href="<?= ROOT ?>users/<?= $_SESSION['seo_name'] ?>" class="nav-item nav-link"><?= $_SESSION['name'] ?>'s profile</a></li>
            <?php if ($_SESSION['role']==2 ) { ?>
              <li><a class="nav-item nav-link" href="<?= ROOT ?>admin">Admin</a></li>
            <?php } ?>
            <li><a href="<?= ROOT ?>users/logout.php" class="nav-item nav-link" >Logout</a></li>
          <?php  } else { ?>
            <li><a href="<?= ROOT ?>login"  class="nav-item nav-link">Login</a></li>
            <li><a href="<?= ROOT ?>register"  class="nav-item nav-link">Register</a></li>
          <?php } ?>
        </ul>
      </div>
    </nav>
  <?php

  ?>