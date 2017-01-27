<?php
require_once('../includes/database_connection.php');
require_once('../includes/functions.php');
$alert = array('status'  => '', 'message' => '');
$email = (isset($_POST['email']) ? $_POST['email'] : '' ); 
$password = (isset($_POST['password']) ? $_POST['password'] : '' ); 
$valid = array('email' => '', 'password' =>'');

function validate_login ($email,$password, $valid) {
  $valid['email'] = (filter_var($email,  FILTER_DEFAULT))? ''   : 'Enter email' ;
  $valid['password'] = (filter_var($password,  FILTER_DEFAULT))? '' : 'Enter password' ;
  return $valid;
}

function create_session($user) {
  session_start();
  $_SESSION['forename'] = $user->forename;
  $_SESSION['image'] = ($user->image ? $user->image : "default.jpg");
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
 $valid = validate_login($email, $password, $valid);
 $validation_failed = array_filter($valid);
 if ($validation_failed == true) {
   $alert = array('status'  => 'danger', 
   'message' => 'Please check errors and resubmit');
 } else {
   $user=get_user_by_email_password($email, $password);
   if ($user) {
      create_session($user);
      header('Location: admin-home.php'); 
    } else {
       $alert = array('status'  => 'danger', 
       'message' => 'Login failed');
    }
  }
} ?>

<form method='post' action='login-cms.php'>
 <span class="<?= $alert['status'] ?>">
  <?= $alert['message'] ?>
 </span><br>
 <label>Email
  <input type='text' name='email' placeholder='Email'/>  
  <span class="<?= $alert['status'] ?>">   
   <?=$valid['email']; ?>
  </span>
 </label><br>
 <label>Password <input type='password' name='password'  
   placeholder='Password' /> 
  <span class="<?= $alert['status'] ?>">
    <?= $valid['password']; ?>
  </span>
 </label><br>
 <button type='submit'>Login</button>    
</form>