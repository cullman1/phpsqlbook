<?php
require_once('../config.php');

$forename  = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname   = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email     = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password  = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
$error    = array('forename' => '', 'surname' =>'', 'email' => '',
                   'password' => '', 'confirm' => '');
$alert     = '';
$show_form = TRUE;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error['forename'] = (Validate::isText($forename) ? '' : 'Please enter a forename.'); 
    $error['surname']  = (Validate::isText($surname) ? '' : 'Please enter a surname.'); 
    $error['email']    = (Validate::isEmail($email) ? '' : 'Please enter a valid email.'); 
    $error['password'] = (Validate::isPassword($password) ? '' : 'Please enter a valid password.'); 
    $error['confirm'] = (Validate::isConfirmPassword($password, $confirm)? '' : 'Please make sure passwords match.'); 
    if (strlen(implode($error)) < 1) {
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
include dirname(__DIR__) .'/includes/header.php'; ?>
<h1>Register</h1>
<?= $alert; ?>
<?php if ($show_form) { ?>
   <form method="post" action="register.php">
  <label>First name <input type="text" name="forename" value="<?=$forename ?>" />
  </label> <span class="error"><?= $error['forename'] ?></span><br />
  <label>Last name <input type="text" name="surname" value="<?=$surname ?>" />
  </label> <span class="error"><?= $error['surname'] ?></span><br />
  <label>Email address <input type="email" name="email" value="<?=$email ?>" />
  </label> <span class="error"><?= $error['email'] ?></span><br />
  <label>Password <input type="password" name="password" />
  </label> <span class="error"><?= $error['password'] ?></span><br />
  <label>Confirm Password <input type="password" name="confirm" />
  </label> <span class="error"><?= $error['confirm'] ?></span><br />
   <button type="submit">Register</button>
</form>
<?php } ?>