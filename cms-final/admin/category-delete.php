<?php
require_once '../config.php';

$userManager->redirectNonAdmin();

$id     = ( isset($_GET['id']) ? $_GET['id'] : ''); // Get values
$alert  = 'Delete not successful';                  // Status messages
$result = $categoryManager->delete($id);

if (isset($result) && ($result === TRUE)) {
  $alert = '<div class="alert alert-success">Category deleted</div>';
  $show_form = FALSE;
}
if (isset($result) && ($result != TRUE)) {
  $alert = '<div class="alert alert-danger">Error: ' . $result . '</div>';
  $show_form = FALSE;
}

include 'includes/header.php';
?>

<section>

  <h2>Delete category</h2>
  <?= $alert ?>

</section>

<?php include 'includes/footer.php'; ?>