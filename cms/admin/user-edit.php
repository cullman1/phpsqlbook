<?php
require_once('../includes/database-connection.php'); 
require_once('../includes/class-lib.php'); 
require_once('includes/functions.php'); 
$id           = ( isset($_GET['user_id'])           ? $_GET['user_id']           : ''); // Get values
$forename         = ( isset($_POST['forename'])        ? $_POST['forename']        : ''); // Get values
$surname         = ( isset($_POST['surname'])        ? $_POST['surname']        : ''); // Get values
$email  = ( isset($_POST['email']) ? $_POST['email'] : ''); // Get values
$image  = ( isset($_POST['image']) ? $_POST['image'] : ''); // Get values
$errors       = array('forename'=>'', 'surname'=>'','email'=>'', 'image'=>'');                      // Form errors
$alert        = '';                                                     // Status messages
$show_form    = TRUE;                                                   // Show or hide form


if (filter_var($id, FILTER_VALIDATE_INT) != FALSE) { // Got a number? Create a category object using function
  $User  = get_user_by_id($id);
}
if (!$User) {  // Did you get a Category object
  $alert = '<div class="alert error">Cannot find user</div>';
}
if (isset($_POST['update'])) {                                       // Submitted - load category data
  $User->id       = $id;                                         // Set properties using form data
  $User->forename     = $forename;                                       // Set properties using form data
  $User->surname = $surname;                             // Set properties using form data
  $User->email = $email;                             // Set properties using form data
  $User->image = $image;                             // Set properties using form data

  $Validate = new Validate();                                        // Create Validation object
  $errors   = $Validate->isUser($User);                      // Validate the object

  if (strlen(implode($errors)) < 1) {
      $result = $User->update();
  } else {
    $alert = '<div class="alert alert-danger">Check form and try again</div>';
  }

  if (isset($result) && ($result == TRUE)) {
    $alert = '<div class="alert alert-success">User updated</div>';
    $show_form = FALSE;
  }
  if (isset($result) && ($result != TRUE)) {
    $alert = '<div class="alert alert-danger">Error: ' . $result . '</div>';
  }

}

include('includes/admin-header.php'); 
?>

<h2>Edit user</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>

<form action="user-edit.php?user_id=<?= $User->id ?>" method="post">
  <div class="form-group">
    <label for="title">Forename: </label>
    <input type="text" name="forename" value="<?= $User->forename ?>" class="form-control">
    <span class="errors"><?= $errors['forename'] ?></span>
  </div>
      <div class="form-group">
    <label for="title">Surname: </label>
    <input type="text" name="surname" value="<?= $User->surname ?>" class="form-control">
    <span class="errors"><?= $errors['surname'] ?></span>
  </div>
      <div class="form-group">
    <label for="title">Email: </label>
    <input type="text" name="email" value="<?= $User->email ?>" class="form-control">
    <span class="errors"><?= $errors['email'] ?></span>
  </div>
  <div class="form-group">
    <label for="description">Image: </label>
 <input type="text" name="image" value="<?= $User->image ?>" class="form-control">
    <span class="errors"><?= $errors['image'] ?></span>
  </div>
  <input type="submit" name="update" value="save" class="btn btn-default">
</form>

<?php } else { 
  include('user.php'); 
}
  include('includes/admin-footer.php');
?>