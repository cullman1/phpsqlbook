<?php

require_once 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id']) ) {  // If check passes
    $article = $articleManager->getArticleById($_GET['id']);
    $article_images = $articleManager->getArticleImages($_GET['id']);
}

if (empty($article)) {
    header( "Location: page-not-found.php" );
}

if (!(isset($article_images)) || sizeof($article_images)<1) {
  $article_images = array();
}

$page_title      .= $article->title . ' ' . $article->category . ' by ' . $article->author;
$meta_description = $article->summary;
include 'includes/header.php';
?>

<section>
  <h1><?= $article->title ?></h1>
  <?= $article->content ?>
  <?php foreach ($article_images as $image) {
    echo '<img src="' . $image->filepath . '" alt="' . $image->alt . '" />';
  }
  ?>
  <img src="<?= $article->media_filepath ?>" alt="<?= $article->media_alt ?>" />
  <div class="credit">
    Posted by <i><?= $article->author ?></i>
    on <i><?= $article->created ?></i> in <i><?= $article->category ?></i>.
  </div>
</section>

<?php include 'includes/footer.php'; ?>