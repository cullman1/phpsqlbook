<?php
include 'config.php';

include 'includes/header.php';
?>

<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading">Page not found</h1>
    <p class="lead text-muted">Sorry, we don't seem to be able to find that page.</p>
  </div>
</section>

<?php echo $_SERVER['HTTP_REFERER'] ?>

<?php include 'includes/footer.php'; ?>