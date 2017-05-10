<?php
session_start();
require_once('/includes/database-connection.php');
require_once('/includes/functions.php');
require_once('/includes/class_lib.php');
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
      header('Location: article-list-role.php'); 
    } else {
      $alert = '<div class="alert alert-danger">Login failed</span>';
    }
  }
} 
?>
<form method="post" action="login.php">
 <?= $alert ?>
 <label>Email <input type="text" name="email" placeholder="Email" />  
  <span class="error"><?= $error['email']; ?></span></label><br>
 <label>Password <input type="password" name="password" placeholder="Password" /> 
  <span class="error"><?= $error['password']; ?></span></label><br>
 <button type='submit'>Login</button>    
</form>