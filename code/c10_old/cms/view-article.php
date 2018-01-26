<?php
  require_once 'config.php';                             // Config information
  $id = ( isset($_GET['id']) ? $_GET['id'] : '');                       
  if (isset($id) && is_numeric($id)) {                    // If have id
    $article = $articleManager->getArticleById($id);     // Get article object
  }
  if (empty($article)) {                                 // If article is empty
    header( "Location: page-not-found.php" );
    exit();                                              // Redirect user
  }                                                      // Otherwise start the template
  $page_title .= htmlentities($article->title, ENT_QUOTES, 'UTF-8') . ' ' .  
                 htmlentities($article->category, ENT_QUOTES, 'UTF-8') . ' by ' .  
                 htmlentities($article->author, ENT_QUOTES, 'UTF-8');
  $meta_description = htmlentities($article->summary, ENT_QUOTES, 'UTF-8');
  include 'includes/header.php';                         // Show the header
?>
<section>
  <h1 class="display-4"><?= htmlentities($article->title, ENT_QUOTES, 'UTF-8') ?></h1>
  <div class="credit">
    <?= htmlentities($article->category, ENT_QUOTES, 'UTF-8') ?> 
    by <a href="<?= ROOT ?>view-user.php?id=<?= $article->user_id ?>">
    <?= htmlentities($article->author, ENT_QUOTES, 'UTF-8') ?></a> 
    on <?= $article->created ?>
  </div>
  <div class="row">
    <div class="col-8"><img src="<?= ROOT ?>uploads/<?= $article->media_file ?>" 
      alt="<?= htmlentities($article->media_alt, ENT_QUOTES, 'UTF-8') ?>" /></div>
    <div class="col-4"><?= $article->content ?></div>
  </div>  
</section>
<?php include 'includes/footer.php'; ?>