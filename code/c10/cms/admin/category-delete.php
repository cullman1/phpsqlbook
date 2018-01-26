<?php
  require_once '../config.php';
  $userManager->redirectNonAdmin();

  $category_id = ( isset($_GET['category_id']) ? $_GET['category_id'] : ''); 
  $alert  = 'Delete not successful';                
  $result = $categoryManager->delete($category_id);
  if (isset($result) && ($result === TRUE)) {
    $alert = '<div class="alert alert-success">Category deleted</div>';
  }
  if (isset($result) && ($result != TRUE)) {
    $alert = '<div class="alert alert-danger">Error: ' . $result . '</div>';
  }
  include 'includes/header.php';
?>
<section>
  <h2>Delete category</h2>
  <?= $alert ?>
</section>
<?php include 'includes/footer.php'; ?>