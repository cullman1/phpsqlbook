<?php

require_once '../config.php';


  $show      = (filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 6);
  $from      = (filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
  $count     = $userManager->getUsersCount();
  $user_list = $userManager->getUsers($show, $from);


  if (empty($user_list)) {
    header( "Location: page-not-found.php" );
    exit();
  }

  $page_title      .= 'Users';
  $meta_description = 'A list of all users';

  include '../includes/header.php'; ?>

  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading">Users</h1>
      <p class="lead text-muted">A list of all users</p>
    </div>
  </section>
 
  <div class="container">
    <div class="row">
    <?php foreach ($user_list as $user) { ?>
        <div class="card" style="width:20rem; margin: 0.4rem;">
          <a href="<?= ROOT ?>users">
            <img class="card-img-top" src="<?= ROOT ?>uploads/thumb/<?= $user->profile_image ?>" alt="<?= $user->getFullName() ?>">
          </a>
          <div class="card-body text-center">
            <a href="<?= ROOT ?>users/<?= $user->seo_name ?>">
              <h5 class="card-title"><?= $user->getFullName()?></h5>
            </a>
          </div>
        </div>
    <?php } ?>
   </div>
  </div>
   <section>
  <?php echo Utilities::createPagination($count, $show, $from); ?>
  </section>
  <?php  include '../includes/footer.php';
  ?>