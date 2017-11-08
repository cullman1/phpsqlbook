<?php
require_once 'config.php';                    // Config information

if (isset($_GET['id']) && is_numeric($_GET['id']) ) {  // If have id
    $article        = $articleManager->getArticleById($_GET['id']); // Get article object
}
if (empty($article)) {                                 // If article is empty
    header( "Location: page-not-found.php" );
    exit();              // Redirect user
}                                                      // Otherwise start the template
$page_title .= $article->title . ' ' . $article->category . ' by ' . $article->author;
$meta_description = $article->summary;
include 'includes/header.php';                         // Show the header
?>
<section>
  <h1><?= $article->title ?></h1>
  <?= $article->content ?>
  <img src="<?= $article->media_filename ?>" alt="<?= $article->media_alt ?>" />
  <div class="credit">
    Posted by <i><?= $article->author ?></i>
    on <i><?= $article->created ?></i> in <i><?= $article->category ?></i>.
  </div>
</section>
<?php include 'includes/footer.php'; ?>