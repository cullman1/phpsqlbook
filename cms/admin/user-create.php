<?php
require_once '../classes/config.php';
require_once '../classes/service/Validate.php';


$cms         = new CMS($database_config);
$userManager = $cms->getUserManager();
$user        = new User();

$forename    = ( isset($_POST['forename']) ? $_POST['forename'] : ''); // Get values
$surname     = ( isset($_POST['surname'])  ? $_POST['surname']  : ''); // Get values
$email       = ( isset($_POST['email'])    ? $_POST['email']    : ''); // Get values
$password    = ( isset($_POST['password']) ? $_POST['password'] : ''); // Get values

$errors      = array('forename' => '', 'surname'=>'', 'email'=>'', 'password'=>'');   // Form errors
$alert       = '';                                           // Status messages

if (isset($_POST['create'])) {
  $errors['forename'] = (Validate::isText($forename, 1, 64) ? '' : 'Not a valid name');
  $errors['surname']  = (Validate::isText($surname, 1, 64)  ? '' : 'Not a valid name');
  $errors['email']    = (Validate::isEmail($email)                    ? '' : 'Not a valid email address');
  $errors['password'] = (Validate::isPassword($email)                 ? '' : 'Not a valid password');

  if (strlen(implode($errors)) < 1) {                  // If data valid
    $user   = new User('', $forename, $surname, $email, $password);       // Create User object
    $result = $userManager->create($user);             // Add user to database
  } else {                                             // Otherwise
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  }

  if ( isset($result) && ($result === TRUE) ) {                // Tried to create and it worked
    $alert = '<div class="alert alert-success">User added: new id is ' . $category->id . '</div>';
    $show_form = FALSE;
  }

  if (isset($result) && ($result !== TRUE) ) {                 // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

include 'includes/header.php';
?>

<h2>Add user</h2>
<?= $alert ?>

<form action="user-create.php" method="post">
  <?php include 'includes/user-form.php'; ?>
</form>

<?php include 'includes/footer.php'; ?>