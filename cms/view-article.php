<?php

require_once 'config.php';

if (isset($_GET['title']) ) {                           // If title exists
    $title = $_GET['title'];                              // Get title
    $article = $articleManager->getArticleBySeoTitle($title);          // Get article
}

if (empty($article)) {
    header( "Location: page-not-found.php" );
}

$page_title      .= $article->title . ' ' . $article->category . ' by ' . $article->author;
$meta_description = $article->summary;
include 'includes/header.php';
?>

<section>
  <h1><?= $article->title ?></h1>
  <?= $article->content ?><?php
if ($userManager->isLoggedIn()) {
  if ($article->liked) {
    echo '<a href="' . ROOT . 'unlike?id=' . $article->id . '">
          <i class="fa fa-heart"></i></a> ';
  } else {
      echo '<a href="' . ROOT . 'like?id=' . $article->id . '">
          <i class="fa fa-heart-o"></i></a> ';
  }
} else {
    echo '<i class="fa fa-heart-o"></i> ';
}
?>
<?= $article->like_count; ?>



  <img src="<?= $article->media_filepath ?>" alt="<?= $article->media_alt ?>" />
  <div class="credit">
    <img src="uploads/user/<?= $article->author_image ?>" alt="<?= $article->author ?>">
    Posted by <i><?= $article->author ?></i>
    on <i><?= $article->created ?></i> in <i><?= $article->category ?></i>.
  </div>
</section>

<?php include 'includes/footer.php'; ?>