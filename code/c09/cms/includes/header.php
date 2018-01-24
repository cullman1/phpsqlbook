<?php
require_once dirname(__DIR__) .'/config.php';
$current_page    = $_SERVER['REQUEST_URI'];
$categoryManager = $cms->getCategoryManager();
$category_list   = $categoryManager->getNavigationCategories();

preg_match('/^\/cms-final\/([A-z0-9\-]+)/i', $current_page, $section);
$section = (isset($section[1]) ? $section[1] : '');

function highlight_nav($section, $url) {
  return (mb_strtolower($section) == mb_strtolower($url) ? 'active' : '');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $page_title ?></title>
    <meta name="description" value=" <?= $meta_description ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/css/styles.css" />
    <script src="https://use.fontawesome.com/3409469903.js"></script>
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
           echo '<a href="' . ROOT . 'view-category.php?category_id=' .  $category_link->category_id . '" class="nav-item nav-link ' . highlight_nav($section, $category_link->name) . '">' . $category_link->name . '</a>';
          }
          ?>
        </ul>     <?php require_once dirname(__DIR__) .'/includes/search.php'; ?>
        <ul class="navbar-nav user-nav">
        </ul>
      </div>
 
    </nav>