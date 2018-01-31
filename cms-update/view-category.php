<?php

require_once 'config.php';

if (isset($_GET['name'])) {
  $name  = ( isset($_GET['name']) ? $_GET['name'] : '' );
  $show  = (filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 6);
  $from  = (filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
  $category   = $categoryManager->getCategoryBySeoName($name);
  if (empty($category)) {
    Utilities::errorPage('page-not-found.php');
  } 
  $count        = $articleManager->getArticleCountByCategorySeoName($category->seo_name); 
  $article_list = $articleManager->getArticleSummariesByCategorySeoName($category->seo_name, $show, $from);
} else {
    Utilities::errorPage('page-not-found.php');
} 

$page_title      .= Utilities::clean($category->name) ;
$meta_description =  Utilities::clean($category->description) ;

include 'includes/header.php'; ?>

  <section class="jumbotron text-center">
      <h1 class="jumbotron-heading"><?=  Utilities::clean($category->name) ?></h1>
      <p class="lead text-muted"><?=  htmlspecialchars_decode($category->description) ?></p>
  </section>

<section>
  <div class="container">
    <div class="row">
    <?php if ($article_list) {
            foreach ($article_list as $article) {
              include 'includes/article-summary.php';
            } 
          } else {
            echo "<p>No articles were found in this category</p>";
          } ?>

   </div>
  </div>
  <br/>
<?php  echo Utilities::createPagination($count, $show, $from);?>
</section>
 <?php include 'includes/footer.php'; ?>