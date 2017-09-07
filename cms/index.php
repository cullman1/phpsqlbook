<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once 'config.php';

    $cms                = new CMS($database_config);
    $categoryManager    = $cms->getCategoryManager();

    $category           = $categoryManager->getCategoryById(1);
    $articleManager     = $cms->getArticleManager();
    $article_list       = $articleManager->getArticleSummariesByCategoryId(1);


$page_title       .= $category->name;
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
  </div>

<?php include 'includes/footer.php'; ?>
?>