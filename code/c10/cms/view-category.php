<?php
  require_once 'config.php';
  $category_id = ( isset($_GET['category_id']) ? $_GET['category_id'] : '');
  if (isset($category_id) && is_numeric($category_id) ) {  // If check passes
    $category        = $categoryManager->getCategoryById($category_id);
    $article_list    = $articleManager->getArticleSummariesByCategoryId($category_id);
  }
  if (empty($category)) {
    header( "Location: page-not-found.php" );
    exit();              // Redirect user
  }
$page_title .= htmlentities($category->name, ENT_QUOTES, 'UTF-8');
  $meta_description = htmlentities($category->description, ENT_QUOTES, 'UTF-8');
  include 'includes/header.php';
?>
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading"><?= htmlentities($category->name, ENT_QUOTES, 'UTF-8'); ?></h1>
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