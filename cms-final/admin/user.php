<?php
// This doesn't have a password when editing the page.
// Do we just address this in the users chapter?
require_once '../config.php';

$userManager->redirectNonAdmin();

// Get data
$id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Get values
$action      = (isset($_GET['action'])       ? $_GET['action'] : 'create'); // Get values
$forename    = ( isset($_POST['forename']) ? $_POST['forename'] : ''); // Get values
$surname     = ( isset($_POST['surname'])  ? $_POST['surname']  : ''); // Get values
$email       = ( isset($_POST['email'])    ? $_POST['email']    : ''); // Get values
$role        = ( isset($_POST['role'])     ? $_POST['role']     : '');  // Get values
$user        = new User($id, $forename, $surname, $email, '', $role);
$errors      = array('forename' => '', 'surname'=>'', 'email'=>'', 'role'=>'');   // Form errors
$alert       = '';                                           // Status messages
// Was form posted
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  // No - show a blank category to create or an existing user to edit
  $user = ($id == '' ? $user : $userManager->getUserById($id)); // Do you load a user
  if (!$user) {
    $alert = '<div class="alert alert-danger">User not found</div>';
  }
} else {  // The form was posted so validate the data and try to update
  $errors['forename'] = (Validate::isName($forename, 1, 64) ? '' : 'Not a valid name');
  $errors['surname']  = (Validate::isName($surname, 1, 64)  ? '' : 'Not a valid name');
  $errors['email']    = (Validate::isEmail($email)          ? '' : 'Not a valid email address');
  $errors['role']     = (Validate::isNumber($role, 1, 2)    ? '' : 'Please select a role');

  if (mb_strlen(implode($errors)) > 0) {                  // If data valid
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  } else {                                             // Otherwise
    if (!empty($userManager->getUserByEmail($email))) {
            $alert = '<div class="alert alert-danger">That email is already in use</div>';
        } else {                   // Otherwise
    if ($action === 'create') {
      $result = $userManager->create($user);             // Add category to database
    }
    if ($action === 'update') {
      $result = $userManager->adminupdate($user);             // Add category to database
    }
    }
  }

  if ( isset($result) && ($result === TRUE) ) {                // Tried to create and it worked
    $alert = '<div class="alert alert-success">Update user ' . $user->id .' succeeded</div>';
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
  <?= $alert ?>

  <form action="user.php?id=<?= htmlspecialchars($id,ENT_QUOTES,'UTF-8'); ?>" method="POST" >
    <div class="form-group">
      <label for="forename">Forename: </label>
      <input name="forename" id="forename" value="<?= htmlentities( $user->forename, ENT_QUOTES, 'UTF-8') ?>" class="form-control">
      <span class="errors"><?= $errors['forename'] ?></span>
    </div>
    <div class="form-group">
      <label for="surname">Surname: </label>
      <input name="surname" id="surname" value="<?= htmlentities( $user->surname, ENT_QUOTES, 'UTF-8') ?>" class="form-control">
      <span class="errors"><?= $errors['surname'] ?></span>
    </div>
    <div class="form-group">
      <label for="email">Email: </label>
      <input type="email" name="email" id="email" value="<?= htmlentities( $user->email, ENT_QUOTES, 'UTF-8') ?>" class="form-control">
      <span class="errors"><?= $errors['email'] ?></span>
    </div>
    <div class="form-group">
      <label for="role">Role: </label>
      <select name="role" id="role">
        <option value="1" <?php if ($user->role == '1') { echo 'selected'; } ?>>Public user</option>
        <option value="2" <?php if ($user->role == '2') { echo 'selected'; } ?>>Administrator</option>
      </select>
    </div>
    <input type="submit" name="create" value="save" class="btn btn-primary">
  </form>

</section>

<?php include 'includes/footer.php'; ?>