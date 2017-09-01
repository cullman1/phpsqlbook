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
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="/cms/">Creative Folk</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <?php
          foreach ($category_list as $category_link) {
            echo '<a href="view-category.php?id=' . $category_link->id . '"  class="nav-item nav-link">' . $category_link->name . '</a>';
          }
          ?>
          <a href="view-article.php?id=13" class="nav-item nav-link">About</a>
          <a href="view-article.php?id=14" class="nav-item nav-link">Contact</a>
        </div>
      </div>
    </nav>