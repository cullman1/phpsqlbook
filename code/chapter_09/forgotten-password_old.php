<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../includes/config.php');

require_once('../includes/database_connection.php');
require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
// Check form data
$show_form = true;
$alert     = array('status'  => '', 'message' => '');
$email     = ( isset($_POST['email']) ? $_POST['email'] : '' );
$valid     = (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false; 

function send_email($to, $subject, $message) {
try {
  $mail = new PHPMailer(true);                                 // Create object
  // How the email is going to be sent
  $mail->IsSMTP();                                         // Set mailer to use SMTP
    $mail->Host     = 'secure.emailsrvr.com';                    // SMTP server address
  $mail->SMTPAuth = true;                                  // SMTP authentication on
  $mail->Username = 'test@deciphered.com';                   // Username
  $mail->Password = 'M3f2gs_egWJF2!';                            // Password
  // Who the email is from and to
  $mail->setFrom('test@deciphered.com');  
  $mail->AddAddress($to);                                  // To
  // Content of email
  $mail_header   = '<!DOCTYPE html PUBLIC...';             // Header goes here
  $mail_footer   = '...</html>';                           // Header goes here
  $mail->Subject = $subject;                               // Set subject of email
  $mail->Body    = $mail_header . $message . $mail_footer; // Set body of HTML email  
  $mail->AltBody = strip_tags($message);                   // Set plain text body
  $mail->CharSet = 'UTF-8';                                // Set character set
  $mail->IsHTML(true);                                    // Set as HTML email
  $mail->Send();
} catch (phpmailerException $e) {
  echo "ERROR: ". $e->errorMessage(); //Pretty error messages from PHPMailer
  return false;
} 
  return true;                                             // Otherwise return false
}

// Functions
function create_iv() {
  $isItSecure = false;
  while ($isItSecure == false) {
    $iv = openssl_random_pseudo_bytes(16, $isItSecure);
    if ($isItSecure) {
      return $iv;
    } 
  }
  return false;
}         // As shown on pXXX
function get_user_by_email($email) {
  $query = 'SELECT * from user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');     // Object
    $user = $statement->fetch();
  }
  return ($user ? $user : false);
}  // As shown on pXXX

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