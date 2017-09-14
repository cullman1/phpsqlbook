<?php
require_once('../config.php');

$forename  = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname   = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email     = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password  = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
$errors    = array('forename' => '', 'surname' =>'', 'email' => '', 'password' => '', 'confirm' => '');
$alert     = '';
$show_form = TRUE;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors['forename'] = (Validate::isText($forename) ? '' : 'Please enter a forename.');
    $errors['surname']  = (Validate::isText($surname) ? '' : 'Please enter a surname.');
    $errors['email']    = (Validate::isEmail($email) ? '' : 'Please enter a valid email.');
    $errors['password'] = (Validate::isPassword($password) ? '' : 'Please enter a valid password.');
    $errors['confirm'] = (Validate::isConfirmPassword($password, $confirm)? '' : 'Please make sure passwords match.');
    if (strlen(implode($errors)) < 1) {
        if (!empty($userManager->getUserByEmail($email))) {
            $alert = '<div class="alert alert-danger">That email is already in use</div>';
        } else {
            $user = new User(0,$forename, $surname, $email, $password, 1);
            $result = $userManager->create($user);
        } 
    }

    if ( isset($result) && ( $result === TRUE ) ) {
        $alert = '<div class="alert alert-success">User added</div>';   
        $show_form = false;
    }

    if ( isset($result) && ( $result !== TRUE ) ) {
        $alert = '<div class="alert alert-danger">' . $result . '</div>';
    }
} 
include '../includes/header.php';

?>
<h1>Register</h1>
<?=$alert;?>

<?php if ($show_form === TRUE) { ?>
  <form action="register.php" method="POST">
  <div class="form-group">
    <label for="forename">Forename: </label>
    <input name="forename" id="forename" value="<?= $forename ?>" class="form-control">
    <span class="errors"><?= $errors['forename'] ?></span>
  </div>
  <div class="form-group">
    <label for="surname">Surname: </label>
    <input name="surname" id="surname" value="<?= $surname ?>" class="form-control">
    <span class="errors"><?= $errors['surname'] ?></span>
  </div>
  <div class="form-group">
    <label for="email">Email: </label>
    <input type="email" name="email" id="email" value="<?= $email ?>" class="form-control">
    <span class="errors"><?= $errors['email'] ?></span>
  </div>
  <div class="form-group">
    <label for="password">Password: </label>
    <input type="password" name="password" id="password" value="<?= $password ?>" class="form-control">
    <span class="errors"><?= $errors['password'] ?></span>
  </div>
  <div class="form-group">
    <label for="password">Confirm password: </label>
    <input type="password" name="confirm" id="confirm" value="<?= $confirm ?>" class="form-control">
    <span class="errors"><?= $errors['confirm'] ?></span>
  </div>
  <input type="submit" name="create" value="save" class="btn btn-default">
</form>
<?php } ?>

<?php include '../includes/footer.php'; ?>
