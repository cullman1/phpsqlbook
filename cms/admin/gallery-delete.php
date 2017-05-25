<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB Connection
require_once('../includes/class-lib.php');                          // Classes
require_once('../includes/functions.php');                          // Classes

$id        = ( isset($_GET['id'])        ? $_GET['id']        : ''); // Get values
$alert     = '';                                                     // Status messages
$show_form = TRUE;

// Got a number? Create a gallery object using function
if (filter_var($id, FILTER_VALIDATE_INT) != FALSE) {
  $Gallery  = get_gallery_by_id($id);                               
}
// Did you get a gallery object
if (!$Gallery) {
  $alert = '<div class="alert error">Cannot find gallery</div>';
}

if (!isset($_POST['confirm'])) {                           // Not submitted - load gallery data
  // Did you get a gallery object
  if ($Gallery) {
    $alert = '<div class="alert alert-danger">Please confirm you want to delete the gallery <b>' . $Gallery->name . '</b></div>';
  } else {
    $alert = '<div class="alert alert-danger">Cannot find gallery</div>';
    $show_form = FALSE;
  }

} else { // Submitted - try to delete

  $Gallery->id = $id;                                         // Set properties using form data
  $result = $Gallery->delete();

  if (isset($result) && ($result == TRUE)) {
    $alert = '<div class="alert alert-success">Gallery deleted</div>';
    $show_form = FALSE;
  }
  if (isset($result) && ($result != TRUE)) {
    $alert = '<div class="alert alert-danger">Error: ' . $result . '</div>';
    $show_form = FALSE;
  }

}

include('includes/admin-header.php'); 
?>

<h2>Delete gallery</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>
<form action="gallery-delete.php?id=<?= $Gallery->id ?>" method="post">
  <input type="submit" name="confirm" value="confirm delete" class="btn btn-default">
</form>
<?php } else {
  include('includes/list-galleries.php'); 
  }
  include('includes/admin-footer.php');
?>