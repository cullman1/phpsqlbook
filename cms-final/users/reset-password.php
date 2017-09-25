<?php
require_once('../config.php');
require_once('../../vendor/PHPMailer/PHPMailerAutoload.php');

$password  = (isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = (isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
$token     = (isset($_GET['token'])     ? $_REQUEST['token'] : '' ); 
$subject   = 'Your password has been updated';
$message   = 'Your password was updated on ' . date('Y-m-d H:i:s');
$show_form = TRUE;
$error    = array('password' => '', 'confirm' => '');
$alert     = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Has form been submitted?  
    $error['password'] = (Validate::isPassword($password) ? 
                                                   '' : 'Please enter a valid password.'); 
    $error['confirm'] = (Validate::isConfirmPassword($password, $confirm) ? 
                                                '' : 'Please make sure passwords match.');

    $alert = '<div class="alert alert-danger">Password not updated.</div>'; 

    if (mb_strlen(implode($error)) < 1) {
        $user = $userManager->getUserFromToken($token, 'password_reset');           // Get user
    }
  if (!empty($user)) {                                               // If found user
    $updated = $userManager->updatePassword($user->id,$password);
  }
  if (!empty($updated)) {
      $userManager->sendEmail($user->email, $subject, $message);                // Send email
    $alert = '<div class="alert alert-success">Password updated.</div>';         
    $show_form = FALSE;                                          // Hide form 
  }
}
include dirname(__DIR__) . '/includes/header.php'; 
?>
<?= $alert ?>
<?php if ($show_form == TRUE) { ?>
  <form method="post" action="reset-password.php?token=<?= $token ?>">
    <h1>Reset Password</h1>
    <label for="password">Enter Your New Password:</label>
    <input type="password" name="password" id="password" /> <?= $error['password']; ?><br />
    <label for="confirm">Confirm Your Password:</label>
    <input type="password" name="confirm" id="confirm" /> <?= $error['confirm']; ?> 
    <input type="submit" value="Submit New Password" />
  </form>   
<?php } ?>
 <?php include dirname(__DIR__) . '/includes/footer.php';  ?>