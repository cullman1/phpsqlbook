<?php
// This doesn't have a password when editing the page.
// Do we just address this in the users chapter?
require_once '../config.php';

$cms->userManager->redirectNonAdmin();

// Get data
$id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Get values
$action      = ( isset($_GET['action'])     ? $_GET['action'] : 'create'); // Get values
$forename    = ( isset($_POST['forename']) ? $_POST['forename'] : ''); // Get values
$surname     = ( isset($_POST['surname'])  ? $_POST['surname']  : ''); // Get values
$email       = ( isset($_POST['email'])    ? $_POST['email']    : ''); // Get values
$role        = ( isset($_POST['role'])     ? $_POST['role']     : '');  // Get values
$user        = new User($id, $forename, $surname, $email, '', $role);
$errors      = array('forename' => '', 'surname'=>'', 'email'=>'', 'role'=>'');   // Form errors

// Was form posted
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  // No - show a blank category to create or an existing user to edit
  $user = ($id == '' ? $user : $cms->userManager->getUserById($id)); // Do you load a user
  if (!$user) $cms->redirect('page-not-found.php'); 
} else {  // The form was posted so validate the data and try to update
  $errors['forename'] = (Validate::isName($forename, 0, 64) ? '' : 'Not a valid name');
  $errors['surname']  = (Validate::isName($surname, 0, 64)  ? '' : 'Not a valid name');
  $errors['email']    = (Validate::isEmail($email)          ? '' : 'Not a valid email address');
  $errors['role']     = (Validate::isNumber($role, 1, 2)    ? '' : 'Please select a role');

  if (strlen(implode($errors)) > 0) {                  // If data valid
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  } else {      
    if ($action === 'update') {
      $result = $cms->userManager->adminupdate($user);             // Add category to database
    } else { 
                               
      if (!empty($cms->userManager->getUserByEmail($email))) {
            $alert = '<div class="alert alert-danger">That email is already in use</div>';
      } else {                  // Otherwise
        if ($action === 'create') {
          $result = $cms->userManager->create($user);             // Add category to database
        }
      }
    }
  }

  if ( isset($result) && ($result === TRUE) ) {                // Tried to create and it worked
    $alert = '<div class="alert alert-success">Update user ' . $user->user_id .' succeeded</div>';
    $action = 'update';
  }

  if (isset($result) && ($result !== TRUE) ) {                 // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

include 'includes/header.php';
?>

<section>

  <h2><?=$action?> user</h2>
  <?= $alert ?? '' ?>

  <form action="user.php?action=<?= $action ?>&id=<?= cleanLink($id); ?>" method="POST" >
    <div class="form-group">
      <label for="forename">Forename: </label>
      <input name="forename" id="forename" value="<?= CMS::clean( $user->forename) ?>" class="form-control">
      <span class="errors"><?= $errors['forename'] ?></span>
    </div>
    <div class="form-group">
      <label for="surname">Surname: </label>
      <input name="surname" id="surname" value="<?= CMS::clean( $user->surname) ?>" class="form-control">
      <span class="errors"><?= $errors['surname'] ?></span>
    </div>
    <div class="form-group">
      <label for="email">Email: </label>
      <input type="email" name="email" id="email" value="<?= CMS::clean( $user->email) ?>" class="form-control">
      <span class="errors"><?= $errors['email'] ?></span>
    </div>
    <div class="form-group">
      <label for="role">Role: </label>
      <select name="role" id="role">
        <option value="1" <?php if ($user->role == '2') { echo 'selected'; } ?>>Public user</option>
        <option value="2" <?php if ($user->role == '1') { echo 'selected'; } ?>>Administrator</option>
      </select>
    </div>
    <input type="submit" name="create" value="save" class="btn btn-primary">
  </form>

</section>

<?php include 'includes/footer.php'; ?>