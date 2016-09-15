<?php
require_once('includes/database_connection.php');
$message = '';
$email = (isset($_POST['email']) ? $_POST['email'] : '' ); 
$password = (isset($_POST['password']) ? $_POST['password'] : '' ); 
$valid = array('email' => '', 'password' =>'');

function validate_login ($email,$password, $valid) {
  $valid['email'] = (filter_var($email,  FILTER_DEFAULT))? ''   : 'Enter email' ;
  $valid['password'] = (filter_var($password,  FILTER_DEFAULT))? '' : 'Enter password' ;
  return $valid;
}

function get_user_by_email_password($email, $password) {
  $query = "SELECT * FROM user WHERE email =:email AND password= :password";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email',$email);
  $statement->bindParam(':password',$password);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  return ($user ? $user : false);
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
   $message = 'Please check errors below and resubmit';
 } else {
   $user = get_user_by_email_password($email, $password);
   if ($user) {
      create_session($user);
      header('Location: admin-home.php'); 
    } else {
      $message = 'Login failed';
    }
  }
}
?>

<form method="post" action="login2.php">
 <div class="error"><?=$message; ?></div>
 <label for="email">Email
  <input type="text" name="email" placeholder="Email"/>  
  <div class='error'><?=$valid['email']; ?></div>
 </label>
 <label for="password">Password
  <input type="password" name="password" placeholder="Password" /> 
  <div class='error'><?= $valid['password']; ?></div>
 </label>
 <button type="submit">Login</button>    
</form>