<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB Connection
require_once('includes/class-lib.php');                          // Classes
require_once('includes/functions.php');                          // Functions

$id           = ( isset($_GET['id'])           ? $_GET['id']           : ''); // Get values
$name         = ( isset($_POST['name'])        ? $_POST['name']        : ''); // Get values
$description  = ( isset($_POST['description']) ? $_POST['description'] : ''); // Get values
$errors       = array('name'=>'', 'description'=>'');                      // Form errors
$alert        = '';                                                     // Status messages
$show_form    = TRUE;                                                   // Show or hide form


if (filter_var($id, FILTER_VALIDATE_INT) != FALSE) { // Got a number? Create a category object using function
  $Category  = get_category_by_id($id);
}
if (!$Category) {  // Did you get a Category object
  $alert = '<div class="alert error">Cannot find category</div>';
}

if (isset($_POST['update'])) {                                       // Submitted - load category data
  $Category->id       = $id;                                         // Set properties using form data
  $Category->name     = $name;                                       // Set properties using form data
  $Category->description = $description;                             // Set properties using form data

  $Validate = new Validate();                                        // Create Validation object
  $errors   = $Validate->isCategory($Category);                      // Validate the object

  if (strlen(implode($errors)) < 1) {
    $result = $Category->update();
  } else {
    $alert = '<div class="alert alert-danger">Check form and try again</div>';
  }

  if (isset($result) && ($result == TRUE)) {
    $alert = '<div class="alert alert-success">Category updated</div>';
    $show_form = FALSE;
  }
  if (isset($result) && ($result != TRUE)) {
    $alert = '<div class="alert alert-danger">Error: ' . $result . '</div>';
  }

}

include('includes/admin-header.php'); 
?>

<h2>Edit category</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>

<form action="category-update.php?id=<?= $Category->id ?>" method="post">
  <div class="form-group">
    <label for="title">Name: </label>
    <input type="text" name="name" value="<?= $Category->name ?>" class="form-control">
    <span class="errors"><?= $errors['name'] ?></span>
  </div>
  <div class="form-group">
    <label for="description">Description: </label>
    <textarea name="description" id="description" class="form-control"><?= $Category->description ?></textarea>
    <span class="errors"><?= $errors['description'] ?></span>
  </div>
  <input type="submit" name="update" value="save" class="btn btn-default">
</form>

<?php } else { 
  include('includes/list-categories.php'); 
}
  include('includes/admin-footer.php');
?>