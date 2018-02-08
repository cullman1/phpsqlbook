<?php
  require_once 'config.php';                             // Config information
  $article_id = ( isset($_GET['article_id']) ? $_GET['article_id'] : '');                       
  if (isset($article_id) && is_numeric($article_id)) {   // If have id
    $article = $articleManager->getArticleById($article_id);     // Get article object
  }  
  if (empty($article)) {                                 // If article is empty
    header( "Location: page-not-found.php" );
    exit();                                              // Redirect user
  }                                                      // Otherwise start the template
$page_title .= CMS::clean($article->title) . ' ' .
                 CMS::clean($article->category) . ' by ' .
                 CMS::clean($article->author);
  $meta_description = CMS::clean($article->summary);
  include 'includes/header.php';                         // Show the header
?>
<section>
 <h1 class="display-4"><?= CMS::clean($article->title) ?></h1>
  <div class="credit">
    <?= CMS::clean($article->category) ?>
    by <a href="<?= ROOT ?>view-user.php?user_id=<?= $article->user_id ?>">
    <?= CMS::clean($article->author) ?></a>
    on <?= $article->created ?>
  </div>
  <div class="row">
    <div class="col-8"><img src="<?= ROOT ?>uploads/<?= $article->image_file ?>" 
      alt="<?= CMS::clean($article->image_alt) ?>" /></div>
    <div class="col-4"><?= $article->content ?></div>
  </div>  
</section>
<?php include 'includes/footer.php'; ?>