<?php
session_start();
require_once('../includes/database-connection.php');
require_once('../includes/functions.php');
require_once('../includes/class-lib.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$error    = array('email' => '', 'password' =>'');
$alert    = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $Validate = new Validate();
  $error['email']     = $Validate->isEmail($email);
  $error['password']  = $Validate->isPasswordLogin($password);
  $valid = implode($error);
  if (strlen($valid) > 0 ) {
    $alert = '<div class="alert alert-danger">Please check your login details</div>';
  } else {
    $user = get_user_by_email_password($email, $password);
    if ($user) {
      create_user_session($user);
      header('Location: /phpsqlbook/cms/admin'); 
    } else {
      $alert = '<div class="alert alert-danger">Login failed</div>';
    }
  }
} 
include '../includes/header.php';
?>
<form class="login-form" method="post" action="login.php">
<fieldset>
<legend>Login</legend>
 <div class="title-error"><?= $alert ?></div>
 <label>Email <input type="text" name="email" placeholder="Email" />  
  <br/><span class="title-error"><?= $error['email']; ?></span></label><br>
 <label>Password <input type="password" name="password" placeholder="Password" /> 
  <span class="error"><?= $error['password']; ?></span></label><br>
  <button type='submit'>Login</button><br><br>
  <a href="/phpsqlbook/cms/forgotten-password.php">Forgotten your password?</a> <br><br> 
  </fieldset>
</form>
 <?php include '../includes/footer.php'; ?>