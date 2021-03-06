<?php
require_once 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id']) ) {  // If check passes
    $category        = $categoryManager->getCategoryById($_GET['id']);
    $article_list    = $articleManager->getArticleSummariesByCategoryId($_GET['id']);
}

if (empty($category)) {
    header( "Location: page-not-found.php" );
    exit();              // Redirect user
}

$page_title      .= $category->name;
$meta_description = $category->description;

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
    <?php
    foreach ($article_list as $article) {
        include 'includes/article-summary.php';
    }
    ?>
   </div>
  </div>

<?php include 'includes/footer.php'; ?>