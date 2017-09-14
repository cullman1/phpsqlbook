<?php
require_once 'config.php';

$article_list   = $articleManager->getHomepageArticleSummaries();

include 'includes/header.php'; ?>
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading">A design agency</h1>
    <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
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

<?php
include 'includes/footer.php';
?>
