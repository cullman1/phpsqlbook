<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../config.php');
require_once('../../vendor/PHPMailer/PHPMailerAutoload.php');

$show_form = TRUE;
$alert = '';
$user = FALSE;
$email = ( isset($_POST['email']) ? $_POST['email'] : '' );
$errors = array('email' => '');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $error['email']    = (Validate::isEmail($email) ? '' : 'Please enter a valid email.'); 

  if (strlen(implode($error)) < 1) {
      $user = $cms->userManager->getUserByEmail($email);
  }
  if ($user) {
    $token = $cms->userManager->createToken($user->user_id,'password_reset'); 
    $link    =  'http://'.$_SERVER['HTTP_HOST'].ROOT. 'users/reset-password.php?token=' . $token;
    $from    = 'no-reply@example.org';
    $subject = 'Reset Password Link';
    $message = 'Use this link to reset your password: 
              <a href="' . $link . '">' . $link . '</a>';
    $result  = $cms->userManager->sendEmail($email, $subject, $message); 
    if ($result === TRUE) { // Check whether email was sent
      $alert = '<div class="alert alert-success">Password reset email sent.</div>';
      $show_form = FALSE;
    } else {
      $alert = '<div class="alert alert-danger">Unable to reset password.</div>';
      echo $message;
    } 
  } else {
      $alert = '<div class="alert alert-danger">Please try again.</div>';
  }
} 
include dirname(__DIR__) . '/includes/header.php'; 
?>

<?php if ($show_form) { ?>
    <div class="container mt-4 mb-4">
      <div class="row justify-content-md-center">
        <div class="col col-lg-4">

  <form  class="login-form" method="post" action="forgotten-password.php">

 <h4 class="card-title">Forgotten Your Password?</h4>
 <div class="title-error"><?= $alert ?></div>
    <label>Enter Your Email Address: <input type="text" name="email" /><br>
    <span class="title-error"> <?= $errors['email']; ?></span></label><br>
    <input type="submit" name="submit" value="Send Reset Link"/><br><br>

  </form> 	
  </div>
  </div>
  </div>
<?php } ?>
 <?php include dirname(__DIR__) . '/includes/footer.php';  ?>