<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB Connection
require_once('../includes/class-lib.php');                          // Classes
require_once('../includes/functions.php');                          // Classes

$id        = ( isset($_GET['id'])        ? $_GET['id']        : ''); // Get values
$alert     = '';                                                     // Status messages
$show_form = TRUE;

// Got a number? Create a category object using function
if (filter_var($id, FILTER_VALIDATE_INT) != FALSE) {
  $Media  = get_media_by_id($id);                               
}
// Did you get a category object
if (!$Media) {
  $alert = '<div class="alert error">Cannot find media</div>';
}

if (!isset($_POST['confirm'])) {     // Not submitted - load category data
  if ($Media) {                      // Did you get a media object
    $alert = '<div class="alert alert-danger">Please confirm you want to delete this media</div>';
  } else {                           // If not...
    $alert = '<div class="alert alert-danger">Cannot find media</div>';
    $show_form = FALSE;
  }

} else { // Submitted - try to delete

  $Media->id = $id;                           // Set properties using form data
  $file   = '../' . $Media->filepath;         // Get file path
  $file   = unlink($file);                    // Delete file from file
  $result = $Media->delete();                 // Delete file from database

  if (isset($file) && ($file == TRUE)) {      // If $file variable has been created and is TRUE
    $alert = '<div class="alert alert-success">Media deleted from server.</div>'; // Success
    $show_form = FALSE;                       // Hide form
  }
  if (isset($file) && ($result != TRUE)) {    // If $file variable has been created and is FALSE
    $alert = '<div class="alert alert-danger">Error deleting media from server.</div>'; // Failed
  }

  if (isset($result) && ($result == TRUE)) {  // If $result variable has been created and is TRUE
    $alert .= '<div class="alert alert-success">Media deleted from database</div>'; // Success
    $show_form = FALSE;                       // Hide form
  }
  if (isset($result) && ($result != TRUE)) {  // If $result variable has been created and is FALSE
    $alert .= '<div class="alert alert-danger">Error: ' . $result . '</div>';  // Failed
  }

}

include('includes/admin-header.php'); 
?>

<h2>Delete media</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>
<form action="media-delete.php?id=<?= $Media->id ?>" method="post">
  Title: <?= $Media->title ?><br>
  File: <img src="../<?= $Media->filepath ?>" /><br>
  <input type="submit" name="confirm" value="confirm delete" class="btn btn-default">
</form>
<?php } else {
  include('includes/list-media.php'); 
  }
  include('includes/admin-footer.php');
?>