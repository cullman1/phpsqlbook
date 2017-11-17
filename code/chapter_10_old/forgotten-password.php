<?php
require_once('/includes/database-connection.php');
require_once('/includes/functions.php');
require_once('/includes/class_lib.php');
require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
$show_form = TRUE;
$alert = '';
$user = FALSE;
$email = ( isset($_POST['email']) ? $_POST['email'] : '' );
$errors = array('email' => '');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $Validate        = new Validate();
  $errors['email'] = $Validate->isEmail($email);
  $valid           = implode($errors);
  // If have valid email, send reset password link
  if (!strlen($valid)>0) {  
    $user = get_user_by_email($email);
  }
  if ($user) {
    $token = $user->createToken('password_reset'); 
    $link    = 'http://localhost/phpsqlbook/code/chapter_10/reset-password.php?token=' . $token;
    $from    = 'no-reply@example.org';
    $subject = 'Reset Password Link';
    $message = 'Use this link to reset your password: 
              <a href="' . $link . '">' . $link . '</a>';
    $result  = send_email($email, $subject, $message); 
    if ($result === TRUE) { // Check whether email was sent
      $alert = '<div class="alert alert-success">Password reset email sent.' . $link .'</div>';
      $show_form = FALSE;
    } else {
      $alert = '<div class="alert alert-danger">Cannot update password.' . $link .'</div>';
    } 
  } else {
      $alert = '<div class="alert alert-danger">Password reset email not sent.</div>';
  }
} ?>
<?= $alert ?>
<?php if ($show_form) { ?>
  <form method="post" action="forgotten-password.php">
    <h1>Forgotten Your Password?</h1>
    <label>Enter Your Email Address: <input type="text" name="email" />
    <?= $errors['email']; ?></label>
    <input type="submit" name="submit" value="Send Reset Link"/>
  </form> 	
<?php } ?>