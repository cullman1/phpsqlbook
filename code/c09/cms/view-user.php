<?php
  require_once 'config.php';

  $user_id = ( isset($_GET['user_id']) ? $_GET['user_id'] : '');
  if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) ) {  // If check passes
    $user           = $userManager->getUserById($_GET['user_id']);
    $users_articles = $articleManager->getArticleSummariesByUserId($_GET['user_id']);
  }
  if (empty($user)) {
    header( "Location: page-not-found.php" );
    exit();              // Redirect user
  }

  $page_title      .= htmlentities($user->getFullName(), ENT_QUOTES, 'UTF-8');
  $meta_description = 'A selection of work by ' . htmlentities($user->getFullName(), ENT_QUOTES, 'UTF-8');
  include 'includes/header.php'; 
?>
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading"><?=htmlentities( $user->getFullName(), ENT_QUOTES, 'UTF-8'); ?></h1>
<img src="uploads/<?= htmlentities($user->picture, ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlentities($user->getFullName(), ENT_QUOTES, 'UTF-8'); ?>"
    class="rounded-circle" style="max-width:100px" onerror="this.style.display='none'"/>
    <p class="lead text-muted">Joined: <?= htmlentities($user->joined, ENT_QUOTES, 'UTF-8'); ?></p>
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