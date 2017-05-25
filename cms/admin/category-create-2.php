<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB connection
require_once('../includes/class-lib.php');                          // Classes
require_once('../includes/functions.php');                          // Classes

$name         = ( isset($_POST['name'])           ? $_POST['name']     : ''); // Get values
$description  = ( isset($_POST['description']) ? $_POST['description'] : ''); // Get values
$errors       = array('id' => '', 'name'=>'', 'description'=>'');             // Form errors
$alert        = '';                                                           // Status messages
$show_form    = TRUE;                                                         // Show / hide form

$Category = new Category('new', $name, $description);           // Create Category object

if (isset($_POST['create'])) {
  $Validate = new Validate();                                // Create Validation object
  $errors   = $Validate->isCategory($Category);              // Validate Category object
  
  if (strlen(implode($errors)) < 1) {                        // If data valid
    $result = $Category->create();                           // Add category to database
  } else {                                                   // Otherwise
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  }

  if ( isset($result) && (is_numeric($result) ) {            // Tried to create and it worked
    $alert = '<div class="alert alert-success">Category added</div>';
    $show_form = FALSE;
  }

  if (isset($result) && (!is_numeric($result)) {             // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

include('includes/admin-header.php'); 
?>

<h2>Add category</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>

<form action="category-create.php" method="post">
  <div class="form-group">
    <label for="title">Name: </label>
    <input type="text" name="name" value="<?= $Category->name ?>"  class="form-control">
    <span class="errors"><?= $errors['name'] ?></span>
  </div>
  <div class="form-group">
    <label for="description">Description: </label>
    <textarea name="description" value="<?= $Category->description ?>" id="description" class="form-control"></textarea>
    <span class="errors"><?= $errors['description'] ?></span>
  </div>
  <input type="submit" name="create" value="save" class="btn btn-default">
</form>
<?php
 } else {
    include('includes/list-categories.php');
  } 
  include('includes/admin-footer.php');
?>