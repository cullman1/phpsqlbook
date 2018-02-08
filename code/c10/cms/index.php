<?php 
  require_once 'config.php';
  $article_list   = $cms->articleManager->getArticleSummaries(9);
  include 'includes/header.php';
?>
<section class="jumbotron text-center">
  <div class="container">
   <h1 class="jumbotron-heading">A design agency</h1>
    <p class="lead text-muted">Something short</p>
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