<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database-connection.php');
require_once('includes/functions.php');
require_once('includes/class-lib.php');
require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
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
    $link    = 'http://localhost/phpsqlbook/cms/reset-password.php?token=' . $token;
    $from    = 'no-reply@example.org';
    $subject = 'Reset Password Link';
    $message = 'Use this link to reset your password: 
              <a href="' . $link . '">' . $link . '</a>';
    $result  = send_email($email, $subject, $message); 
    if ($result === TRUE) { // Check whether email was sent
      $alert = '<div class="alert alert-success">Password reset email sent.</div>';
      $show_form = FALSE;
    } else {
      $alert = '<div class="alert alert-danger">Unable to reset password.</div>';
    } 
  } else {
      $alert = '<div class="alert alert-danger">Please try again.</div>';
  }
} 
get_HTML_template('header');
?>

<?php if ($show_form) { ?>
  <form  class="login-form" method="post" action="forgotten-password.php">
  <fieldset >
<legend>Forgotten Your Password?</legend>
 <div class="title-error"><?= $alert ?></div>
    <label>Enter Your Email Address: <input type="text" name="email" /><br>
    <span class="title-error"> <?= $errors['email']; ?></span></label><br>
    <input type="submit" name="submit" value="Send Reset Link"/><br><br>
    </fieldset>
  </form> 	
<?php } ?>
 <?= get_HTML_template('footer'); ?>