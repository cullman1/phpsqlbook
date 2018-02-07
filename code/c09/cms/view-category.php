<?php
  require_once 'config.php';
  $id = ( isset($_GET['category_id']) ? $_GET['category_id'] : '');
  if (isset($id) && is_numeric($id) ) {  // If check passes
    $category        = $cms->categoryManager->getCategoryById($id);
    $article_list    = $cms->articleManager->getArticleSummariesByCategoryId($id);
  }
  if (empty($category)) {
    header( "Location: page-not-found.php" );
    exit();              // Redirect user
  }
$page_title .= CMS::clean($category->name);
  $meta_description = CMS::clean($category->description);
  include 'includes/header.php';
?>
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading"><?= CMS::clean($category->name); ?></h1>
    <p class="lead text-muted"><?= $category->description ?></p>
  </div>
</section>
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
<?php include 'includes/footer.php'; ?>