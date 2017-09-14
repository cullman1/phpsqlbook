<?php
$current_page    = basename($_SERVER["SCRIPT_FILENAME"], '.php');
$categoryManager = $cms->getCategoryManager();
$category_list   = $categoryManager->getNavigationCategories();

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
        <div class="navbar-nav">
          <?php
          foreach ($category_list as $category_link) {
           echo '<a href="' . ROOT . $category_link->seo_name . '" class="nav-item nav-link">' . $category_link->name . '</a>';
          }
          ?>

          <?php if ($is_logged_in) { ?>
            <span class="nav-item">Hello <?= $_SESSION["name"] ?></span>
            <a class="nav-item nav-link" href="<?= ROOT ?>members/logout.php">Logout</a></a>
          <?php  } else { ?>
            <a href="<?= ROOT ?>members/login.php">Login</a>
          <?php } ?>

        </div>
      </div>
    </nav>