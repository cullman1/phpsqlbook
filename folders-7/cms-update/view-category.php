<?php

require_once 'config.php';

if (isset($_GET['name'])) {
  $name  = ( isset($_GET['name']) ? $_GET['name'] : '' );
  $show  = (filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 6);
  $from  = (filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
  $category   = $cms->categoryManager->getCategoryBySeoName($name);
  if (empty($category)) {
    CMS::redirect('page-not-found.php');
  } 
  $count        = $cms->articleManager->getArticleCountByCategorySeoName($category->seo_name); 
  $article_list = $cms->articleManager->getArticleSummariesByCategorySeoName($category->seo_name, $show, $from);
} else {
    CMS::redirect('page-not-found.php');
} 

$page_title      .= CMS::clean($category->name) ;
$meta_description =  CMS::clean($category->description) ;

include 'includes/header.php'; ?>

  <section class="jumbotron text-center">
      <h1 class="jumbotron-heading"><?=  CMS::clean($category->name) ?></h1>
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
<?php  echo CMS::createPagination($count, $show, $from);?>
</section>
 <?php include 'includes/footer.php'; ?>