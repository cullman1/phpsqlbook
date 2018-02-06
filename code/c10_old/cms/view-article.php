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
$page_title .= Utilities::clean($article->title) . ' ' .  
                 Utilities::clean($article->category) . ' by ' .  
                 Utilities::clean($article->author);
  $meta_description = Utilities::clean($article->summary);
  include 'includes/header.php';                         // Show the header
?>
<section>
 <h1 class="display-4"><?= Utilities::clean($article->title) ?></h1>
  <div class="credit">
    <?= Utilities::clean($article->category) ?> 
    by <a href="<?= ROOT ?>view-user.php?user_id=<?= $article->user_id ?>">
    <?= Utilities::clean($article->author) ?></a> 
    on <?= $article->created ?>
  </div>
  <div class="row">
    <div class="col-8"><img src="<?= ROOT ?>uploads/<?= $article->image_file ?>" 
      alt="<?= Utilities::clean($article->image_alt) ?>" /></div>
    <div class="col-4"><?= $article->content ?></div>
  </div>  
</section>
<?php include 'includes/footer.php'; ?>