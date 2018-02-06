<?php
  require_once 'config.php';
  $id = ( isset($_GET['category_id']) ? $_GET['category_id'] : '');
  if (isset($id) && is_numeric($id) ) {  // If check passes
    $category        = $categoryManager->getCategoryById($id);
    $article_list    = $articleManager->getArticleSummariesByCategoryId($id);
  }
  if (empty($category)) {
    header( "Location: page-not-found.php" );
    exit();              // Redirect user
  }
$page_title .= Utilities::clean($category->name);
  $meta_description = Utilities::clean($category->description);
  include 'includes/header.php';
?>
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading"><?= Utilities::clean($category->name); ?></h1>
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