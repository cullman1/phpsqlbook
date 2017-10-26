<?php

require_once 'config.php';

if (isset($_GET['name'])) {  // If check passes
    $user       = $userManager->getUserBySeoName($_GET['name']);
    $my_profile = $userManager->isCurrentUser($_GET['name']);
}

if (empty($user) ) {
    header( "Location: user-upload.php?include=croppie&action=create" );
    exit();
} 

$page_title      .= $user->getFullName();
$meta_description = 'A selection of work by ' . $user->getFullName();

$users_articles   = $articleManager->getArticleSummariesByUserId($user->id);
if (!(isset($users_articles)) || sizeof($users_articles)<1) {
  $users_articles = array();
}

include 'includes/header.php'; ?>

  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading"><?= $user->getFullName() ?></h1>
      <img src="<?= ROOT ?>uploads/thumb/<?= $user->profile_image ?>" alt="<?= $user->getFullName() ?>" class="rounded-circle" style="max-width: 100px" />
      <p class="lead text-muted">Joined: <?= $user->joined ?></p>
      <?php if ($my_profile) {
        echo '<a href="' . ROOT . 'users/create/" class="btn btn-primary">upload work</a>';
      } ?>
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