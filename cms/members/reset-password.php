<?php
require_once('includes/database-connection.php');
require_once('includes/functions.php');
require_once('includes/class_lib.php');
require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$password  = (isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = (isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
$token     = (isset($_GET['token'])     ? $_REQUEST['token'] : '' ); 
$subject   = 'Your password has been updated';
$message   = 'Your password was updated on ' . date('Y-m-d H:i:s');
$show_form = TRUE;
$errors    = array('password' => '', 'confirm' => '');
$alert     = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Has form been submitted?  
  $Validate = new Validate();
  $errors['password'] = $Validate->isPassword($password);
  $errors['confirm']  = $Validate->isConfirmPassword($password, $confirm);
  $valid = implode($errors);
  $alert = '<div class="alert alert-danger">Password not updated.</div>'; 

  if (strlen($valid) < 1) {
    $user = get_user_from_token($token, 'password_reset');           // Get user
  }
  if (!empty($user)) {                                               // If found user
    $updated = $user->update_password($password);
  }
  if (!empty($updated)) {
    send_email($user->email, $subject, $message);                // Send email
    $alert = '<div class="alert alert-success">Password updated.</div>';         
    $show_form = FALSE;                                          // Hide form 
  }
}
?>
<?= $alert ?>
<?php if ($show_form == TRUE) { ?>
  <form method="post" action="reset-password.php?token=<?= $token ?>">
    <h1>Reset Password</h1>
    <label for="password">Enter Your New Password:</label>
    <input type="password" name="password" id="password" /> <?= $errors['password']; ?>
    <label for="confirm">Confirm Your Password:</label>
    <input type="password" name="confirm" id="confirm" /> <?= $errors['confirm']; ?> 
    <input type="submit" value="Submit New Password" />
  </form>   
<?php } ?>