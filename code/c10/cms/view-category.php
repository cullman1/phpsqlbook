<?php
  require_once 'config.php';
if (filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT)) {
    $category        = $cms->categoryManager->getCategoryById($_GET['category_id']);
    $article_list    = $cms->articleManager->getArticleSummariesByCategoryId($_GET['category_id']);
}
if (empty($category)) CMS::redirect('page-not-found.php');
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