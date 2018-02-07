<?php
  require_once 'config.php';

  if (filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT)) {
    $user           = $cms->userManager->getUserById($_GET['user_id']);
    $users_articles = $cms->articleManager->getArticleSummariesByUserId($_GET['user_id']);
  }
  if (empty($user)) CMS::redirect('page-not-found.php');
  $page_title      .= CMS::clean($user->getFullName());
  $meta_description = 'A selection of work by ' . CMS::clean($user->getFullName());
  include 'includes/header.php'; 
?>
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading"><?=CMS::clean( $user->getFullName()); ?></h1>
<img src="uploads/<?= CMS::clean($user->picture); ?>" alt="<?= CMS::clean($user->getFullName()); ?>"
    class="rounded-circle" style="max-width:100px" onerror="this.style.display='none'"/>
    <p class="lead text-muted">Joined: <?= CMS::clean($user->joined); ?></p>
  </div>
</section>
<div class="container">
  <div class="row">
    <?php
      if ($users_articles) {
        foreach ($users_articles as $article) {
          include 'includes/article-summary.php';
        }
      } else {
        echo "<p>No articles were found for this user</p>";
       }    
    ?>
  </div>
</div>
<?php include 'includes/footer.php'; ?>