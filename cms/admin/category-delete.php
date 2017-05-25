<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB Connection
require_once('includes/class-lib.php');                          // Classes
require_once('includes/functions.php');                          // Classes

$id        = ( isset($_GET['id']) ? $_GET['id'] : '');              // Get values
$alert     = '';                                                    // Status messages
$show_form = TRUE;

// Got a number? Create a category object using function
if (filter_var($id, FILTER_VALIDATE_INT) != FALSE) {
  $Category  = get_category_by_id($id);                               
}
// Did you get a category object
if (!$Category) {
  $alert = '<div class="alert error">Cannot find category</div>';
}

if (!isset($_POST['confirm'])) {                           // Not submitted - load category data
  // Did you get a category object
  if ($Category) {
    $alert = '<div class="alert alert-danger">Please confirm you want to delete this information</div>';
  } else {
    $alert = '<div class="alert alert-danger">Cannot find category</div>';
    $show_form = FALSE;
  }

} else { // Submitted - try to delete

  $Category->id = $id;                                         // Set properties using form data
  $result = $Category->delete();

  if (isset($result) && ($result == TRUE)) {
    $alert = '<div class="alert alert-success">Category deleted</div>';
    $show_form = FALSE;
  }
  if (isset($result) && ($result != TRUE)) {
    $alert = '<div class="alert alert-danger">Error: ' . $result . '</div>';
    $show_form = FALSE;
  }

}

include('includes/admin-header.php'); 
?>

<h2>Delete category</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>
<form action="category-delete.php?id=<?= $Category->id ?>" method="post">
  Name: <?= $Category->name ?><br>
  Description: <?= $Category->description ?><br>
  <input type="submit" name="confirm" value="confirm delete" class="btn btn-default">
</form>
<?php } else {
  include('includes/list-categories.php'); 
  }
  include('includes/admin-footer.php');
?>