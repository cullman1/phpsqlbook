<?php
require_once('../config.php');

$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$alert  = '';          // Create as one - I think at this point
$error = array('email' => '', 'password'=>'');             // Form errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error['email']     = (Validate::isEmail($email)  ? ''    : 'Please enter a valid email address.');
    $error['password']  = (Validate::isPassword($password) ? ''    : 'Your password must contain 1 uppercase letter, 1 lowercase letter, 
            and a number. It must be between 8 and 32 characters.');
    $valid = implode($error);
    if (strlen($valid) > 0 ) {
      $alert = '<div class="alert alert-danger">Please check your login details</div>';
    } else {
      $user = $userManager->getUserByEmailPassword($email, $password);
      if ($user) {
        $userManager->createUserSession($user);
        header('Location: http://localhost/phpsqlbook/cms/admin/'); 
      } else {
        $alert = '<div class="alert alert-danger">Login failed</span>';
    }
  }

} 
include dirname(__DIR__) .'/includes/header.php'; 
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
  <a href="forgotten-password.php">Forgotten your password?</a> <br><br> 
  </fieldset>
</form>
 <?php include dirname(__DIR__) .'/includes/footer.php';  ?>