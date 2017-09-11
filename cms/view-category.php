<?php

require_once 'config.php';

if (isset($_GET['name'])) {
    $name  = ( isset($_GET['name']) ? $_GET['name'] : '' );
    $show  = (filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 3);
    $from  = (filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
    $category     = $categoryManager->getCategoryBySeoName($name);                 // Get category
    $count        = $articleManager->getArticleCountByCategorySeoName($category->seo_name);   // Get article count
    $article_list = $articleManager->getArticleSummariesByCategorySeoName($name, $show, $from); // articles
}

if (empty($category)) {
    header( "Location: page-not-found.php" );
}

$page_title      .= $category->name;
$meta_description = $category->description;

include 'includes/header.php'; ?>

  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading"><?= $category->name ?></h1>
      <p class="lead text-muted"><?= $category->description ?></p>
    </div>
  </section>

  <div class="container">
    <div class="row">
    <?php
    
      foreach ($article_list as $article) {
        include 'includes/article-summary.php';
      }
    ?>
   </div>
  </div><?php
        echo $articleManager->createPagination($count, $show, $from);
 include 'includes/footer.php'; ?>