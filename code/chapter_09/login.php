<?php
session_start();
require_once('../includes/database_connection.php');
require_once('functions.php');
$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$error    = array('email' => '', 'password' =>'');
$alert  =   array('status' => '', 'message' =>'');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  include('../includes/validate.php');
  $Validate = new Validate();
  $error['email']     = $Validate->isEmail($email);
  $error['password']  = $Validate->isPassword($password);
  $valid = implode($error);
  if (strlen($valid) > 0 ) {
    $alert = array('status'  => 'danger', 'message' => 'Please check and resubmit');  
  } else {
    $user=get_user_by_email_password($email, $password);
    if ($user) {
      create_user_session($user);
      header('Location: admin-home.php'); 
    } else {
       $alert = array('status'  => 'danger', 'message' => 'Login failed');
    }
  }
} 
?>
<form method='post' action='login.php'>
 <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span><br>
 <label>Email  
  <input type='text' name='email' placeholder='Email'/>  
  <span class="error"><?= $error['email']; ?></span>
 </label><br>
 <label>Password 
  <input type='password' name='password' placeholder='Password' /> 
  <span class="error"><?= $error['password']; ?></span>
 </label><br>
 <button type='submit'>Login</button>    
</form>