<?php
 require_once('/includes/database-connection.php');
 require_once('/includes/functions.php');

 require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
 require_once('../classes/class_lib.php');
 $show_form = true;
 $subject   = 'Your password has been updated';
 $message   = 'Your password was updated on ' . date("Y-m-d H:i:s");
 $password  = (isset($_POST['password']) ? $_POST['password'] : '' ); 
 $confirm   = (isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
 $token     = (isset($_REQUEST['token']) ? $_REQUEST['token'] : '' ); 
 $errors    = array('password' => '', 'confirm' => '');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $Validate = new Validate();
  $errors['password']  = $Validate->isStrongPassword($confirm);
  $errors['confirm']   = $Validate->isConfirmPassword($password, $confirm);
  $valid = implode($errors);
  $alert = 'Check form and try again';
  if (strlen($valid)<2) {  
    $alert = '<div class="alert alert-danger">Password not updated.</div>';
    $user = get_user_from_token($token, 'password_reset');                 
      if ($user) {                          
        if (update_password($password, $user->id) === TRUE) {        // Update password
          $alert = '<div class="alert alert-danger">Password updated.</div>';         
          send_email($email, $subject, $message);                    // Send email
          $show_form = FALSE;                                        // Hide form
        }
      }
    } 
} ?>
<?= $alert ?>
<?php if ($show_form == true) { ?>
  <form method="post" action="reset-password.php">
    <h1>Reset Your Password</h1>
    <label>Enter Your New Password: 
    <input type="password" name="password" /> <?= $errors['password']; ?> </label>
    <label>Confirm Your Password: 
    <input type="password" name="confirm" /> <?= $errors['confirm']; ?> </label> 
    <input type="hidden" name="token" value="<?= $token ?>" />
    <input type="submit" name="submit_button" value="Submit New Password" />
  </form>
<?php } ?>