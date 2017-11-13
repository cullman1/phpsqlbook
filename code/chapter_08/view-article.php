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
  <h1 class="display-4"><?= $article->title ?></h1>
  <div class="credit">
    <?= $article->category ?> by <a href="<?= ROOT ?>view-user.php?id=<?= $article->user_id ?>"><?= $article->author ?></a> on <?= $article->created ?>
  </div>
  <div class="row">
    <div class="col-8"><img src="<?= ROOT ?>uploads/<?= $article->media_file ?>" 
                      alt="<?= $article->media_alt ?>" /></div>
    <div class="col-4"><?= $article->content ?></div>
  </div>  
</section>
<?php include 'includes/footer.php'; ?>