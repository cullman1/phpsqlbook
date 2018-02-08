<?php
  require_once 'config.php';                             // Config information
  if (filter_input(INPUT_GET, 'article_id', FILTER_VALIDATE_INT)) {
    $article = $cms->articleManager->getArticleById($_GET['article_id']);     // Get article object
  }  
  if (empty($article)) CMS::redirect('page-not-found.php');                                 // Otherwise start the template
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