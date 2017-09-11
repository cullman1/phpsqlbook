<?php
require_once '../classes/config.php';

$cms             = new CMS($database_config);
$categoryManager = $cms->getCategoryManager();

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

  <h2>Delete category</h2>
  <?= $alert ?>

<?php include 'includes/footer.php'; ?>