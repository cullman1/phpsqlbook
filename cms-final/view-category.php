<?php

require_once 'config.php';

if (isset($_GET['name'])) {
  $name  = ( isset($_GET['name']) ? $_GET['name'] : '' );
  $show  = (filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 6);
  $from  = (filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
  $category   = $categoryManager->getCategoryBySeoName($name);
  if (empty($category)) {
     header( "Location: http://".$_SERVER['HTTP_HOST']. ROOT.'page-not-found.php' );
    exit();
  } 
  $count        = $articleManager->getArticleCountByCategorySeoName($category->seo_name); 
  $article_list = $articleManager->getArticleSummariesByCategorySeoName($category->seo_name, $show, $from);
}

if (empty($category)) {
  header( "Location: page-not-found.php" );
   exit();
} 

$page_title      .= $category->name;
$meta_description = $category->description;

include 'includes/header.php'; ?>

  <section class="jumbotron text-center">
      <h1 class="jumbotron-heading"><?=  htmlentities($category->name, ENT_QUOTES, 'UTF-8') ?></h1>
      <p class="lead text-muted"><?=  htmlspecialchars_decode($category->description) ?></p>
  </section>

<section>
  <div class="container">
    <div class="row">
    <?php
      foreach ($article_list as $article) {
        include 'includes/article-summary.php';
      }
    ?>
   </div>
  </div>
</section>
<section>
<?php  echo Utilities::createPagination($count, $show, $from);?>
</section>
 <?php include 'includes/footer.php'; ?>