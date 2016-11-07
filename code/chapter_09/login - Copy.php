<?php session_start();
require_once('../includes/database_connection.php');
require_once('functions.php');
  
$alert    = array('status'  => '', 'message' => '');
$email    = (isset($_POST['email']) ? $_POST['email'] : '' ); 
$password = (isset($_POST['password']) ? $_POST['password'] : '' ); 
$valid    = array('email' => '', 'password' =>'');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
 $valid = validate_login($email, $password, $valid);
 $validation_failed = array_filter($valid);
 if ($validation_failed == true) {
   $alert = array('status' => 'danger', 'message' => 'Please check and resubmit');
 } else {
   $user=get_user_by_email_password($email, $password);
   if ($user) {
      create_user_session($user);
      header('Location: admin-home.php'); 
      exit;
    } else {
       $alert = array('status'  => 'danger', 'message' => 'Login failed');
    }
  }
} 
?>
<form method='post' action='login.php'>
 <span class="<?= $alert['status'] ?>"><?= $alert['message'] ?></span><br>
 <label>Email  
  <input type='text' name='email' placeholder='Email'/>  
  <span class="<?= $alert['status'] ?>"><?= $valid['email']; ?></span>
 </label><br>
 <label>Password 
  <input type='password' name='password' placeholder='Password' /> 
  <span class="<?= $alert['status'] ?>"><?= $valid['password']; ?></span>
 </label><br>
 <button type='submit'>Login</button>    
</form>