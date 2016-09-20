<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');
require_once('../includes/database_connection.php');
require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
// Check form data
$show_form = true;
$alert     = array('status'  => '', 'message' => '');
$email     = ( isset($_POST['email']) ? $_POST['email'] : '' );
$valid     = (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false; 
// Functions

function add_password($password, $id){
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $query = 'UPDATE user set password = :pass WHERE id= :id';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':pass', $hash);
  $statement->bindParam(':id', $id);
  $statement->execute();
  if($statement->errorCode() != 0) {  
    return $statement->errorCode();
  }
  return true;
}

// If have valid email, send reset password link
if (($valid) && (get_user_by_email($email) ) ) {
  // Create secure link to reset password page
  $iv      = create_iv();
  $token   = $email . '#' . time();
  $token   = openssl_encrypt($token, METHOD, KEY, OPENSSL_RAW_DATA, $iv);
  $token   = rawurlencode(base64_encode($token));
  $iv      = rawurlencode(base64_encode($iv));
  $link    = 'http://localhost/phpsqlbook/code/chapter_09/reset-password.php?token=' . $token . '&iv=' . $iv;
  // Setup email and send
  $from    = 'no-reply@example.org';
  $subject = 'Reset Password Link';
  $message = 'Use this link to reset your password: 
              <a href="' . $link . '">' . $link . '</a>';
  $result  = send_email($email, $subject, $message); 
  // Check whether email was sent
  if ($result) { 
    $alert = array('status'  => 'success', 'message' => 'Password reset email sent.');
    $show_form = false;
  } else {
    $alert = array('status'  => 'danger', 'message' => 'Cannot update password.');
  }
} ?>
<!-- Check whether email was sent//-->
<div class="<?= $alert['status'] ?>"><?= $alert['message'] ?></div>
<?php if ($show_form) { ?>
  <form method="post" action="forgotten-password.php">
    <h1>Forgotten Your Password?</h1>
    <label>Enter Your Email Address: <input type="text" name="email" /></label><br />
    <input type="submit" name="submit" value="Send Reset Link"/>
  </form> 	
<?php } ?>