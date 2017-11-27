<?php

require_once 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id']) ) {  // If check passes
    $user           = $userManager->getUserById($_GET['id']);
    $users_articles = $articleManager->getArticleSummariesByUserId($_GET['id']);
}

if (empty($user)) {
    header( "Location: page-not-found.php" );
    exit();              // Redirect user
}

$page_title      .= $user->getFullName();
$meta_description = 'A selection of work by ' . $user->getFullName();

include 'includes/header.php'; ?>

  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading"><?= $user->getFullName() ?></h1>
      <img src="uploads/users/<?= $user->image ?>" alt="<?= $user->getFullName() ?>"
                class="rounded-circle" style="max-width: 100px" />
      <p class="lead text-muted">Joined: <?= $user->joined ?></p>
    </div>
  </section>

  <div class="container">
    <div class="row">
    <?php
    foreach ($users_articles as $article) {
        include 'includes/article-summary.php';
    }
    ?>
    </div>
  </div>

<?php include 'includes/footer.php'; ?>