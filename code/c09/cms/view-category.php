<?php
  require_once 'config.php';
  $id = ( isset($_GET['id']) ? $_GET['id'] : '');
  if (isset($id) && is_numeric($id) ) {  // If check passes
    $category        = $categoryManager->getCategoryById($id);
    $article_list    = $articleManager->getArticleSummariesByCategoryId($id);
  }
  if (empty($category)) {
    header( "Location: page-not-found.php" );
    exit();              // Redirect user
  }
  $page_title      .= htmlentities($category->name, ENT_QUOTES, 'UTF-8') ;
$meta_description =  htmlentities($category->description, ENT_QUOTES, 'UTF-8') ;
  include 'includes/header.php';
?>
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading"><?= $category->name ?></h1>
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