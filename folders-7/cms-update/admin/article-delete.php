<?php
require_once '../config.php';

$cms->userManager->redirectNonAdmin();

$id     = ( isset($_GET['id']) ? $_GET['id'] : ''); // Get values
$alert  = 'Delete not successful';                  // Status messages
$result = $cms->articleManager->delete($id);

if (isset($result) && ($result === TRUE)) {
  $alert = '<div class="alert alert-success">Article deleted</div>';
  $show_form = FALSE;
}
if (isset($result) && ($result != TRUE)) {
  $alert = '<div class="alert alert-danger">Error: ' . $result . '</div>';
  $show_form = FALSE;
}

include 'includes/header.php';
?>
  <section>
    <h2>Delete article</h2>
    <?= $alert ?>
  </section>
<?php include 'includes/footer.php'; ?>