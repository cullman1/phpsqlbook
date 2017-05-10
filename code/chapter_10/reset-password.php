<?php
 require_once('/includes/functions.php');
 require_once('../includes/database_connection.php');
 require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
 require_once('../classes/class_lib.php');
 $show_form = true;
 $subject   = 'Your password has been updated';
 $message   = 'Your password was updated on ' . date("Y-m-d H:i:s");
 $password  = (isset($_POST['password']) ? $_POST['password'] : '' ); 
 $confirm   = (isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
 $token     = (isset($_REQUEST['token']) ? $_REQUEST['token'] : '' ); 

 // Check 1: Has form been submitted?  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $Validate = new Validate();
  $error['password']      = $Validate->isStrongPassword($confirm);
  $error['confirm']   = $Validate->isConfirmPassword($password, $confirm);
  $valid = implode($error);
  $alert = 'Check form and try again';
  // Check 2: Is form valid?  
  if (strlen($valid)<2) {  
    // If success set new default error message, as form has no errors
    $alert = '<div class="alert alert-danger">Password not updated.</div>';
    // Check 3: Try to get email and store it in $email
    $user = get_user_from_token($token, 'password_reset');                 
      if ($user) {       
        // If success Check 4: Try to update password                               
        if (update_password($password, $user->id)===true) {   
          // If success Check 5: If email sent without errors
          $alert = '<div class="alert alert-danger">Password updated but mail confirmation not sent.</div>';         
          if (send_email($email, $subject, $message)===true) {
            $alert     =  '<div class="alert alert-success">Password updated.</div>';
            $show_form = false;
          }
        }
      }
    } 
} ?>
<?= $alert ?>
<?php if ($show_form == true) { ?>
  <form method="post" action="reset-password.php">
    <h1>Reset Your Password</h1>
    <label>Enter Your New Password: 
    <input type="password" name="password" /> <?= $error['password']; ?> </label>
    <label>Confirm Your Password: 
    <input type="password" name="confirm" /> <?= $error['confirm']; ?> </label> 
    <input type="hidden" name="token" value="<?= $token ?>" />
    <input type="submit" name="submit_button" value="Submit New Password" />
  </form>			
<?php } ?>