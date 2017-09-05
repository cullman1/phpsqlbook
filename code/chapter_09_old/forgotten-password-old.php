<?php
require_once('../includes/config.php');
require_once('../includes/database_connection.php');
require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
// Check form data
$show_form = true;
$alert     = array('status'  => '', 'message' => '');
$email     = ( isset($_POST['email']) ? $_POST['email'] : '' );
$error    = array('email' => '');
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
}        // As shown on pXXX
function get_user_by_email($email) {
  $query = 'SELECT * from user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email', $email);
  $statement->execute();
  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');            
    $user = $statement->fetch();
  }
  return ($user ? $user : false);
}

function send_email($to, $subject, $message) {
try {
  $mail = new PHPMailer(true);                             // Create object
  $mail->IsSMTP();                                         // Set mailer to use SMTP
  $mail->Host     = 'secure.emailsrvr.com';                    // SMTP server address
  $mail->SMTPAuth = true;                                  // SMTP authentication on
  $mail->Username = 'test@deciphered.com';                   // Username
  $mail->Password = 'M3f2gs_egWJF2';                            // Password
  $mail->setFrom('test@deciphered.com');                  // From
  $mail->AddAddress($to);                                  // To
  $mail_header   = '<!DOCTYPE html PUBLIC...';             // Header goes here
  $mail_footer   = '...</html>';                           // Header goes here
  $mail->Subject = $subject;                               // Set subject of email
  $mail->Body    = $mail_header . $message . $mail_footer; // Set body of HTML email  
  $mail->AltBody = strip_tags($message);                   // Set plain text body
  $mail->CharSet = 'UTF-8';                                // Set character set
  $mail->IsHTML(true);                                    // Set as HTML email
   $mail->Send();
} catch (phpmailerException $e) {
    echo $e->errorMessage();                              //Error message from PHPMailer
  return false;
} 
  return true;     
}
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once('../classes/validate.php');
  $Validate = new Validate();
  $error['email']      = $Validate->isEmail($email);
  $valid = implode($error);
// If have valid email, send reset password link
if ((strlen($valid)<2)  && (get_user_by_email($email) ) ) {
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
  }
} ?>
<!-- Check whether email was sent//-->
<div class="<?= $alert['status'] ?>"><?= $alert['message'] ?></div>
<?php if ($show_form) { ?>
  <form method="post" action="forgotten-password.php">
    <h1>Forgotten Your Password?</h1>
    <label>Enter Your Email Address: <input type="text" name="email" /><?= $error['email']; ?></label><br />
    <input type="submit" name="submit" value="Send Reset Link"/>
  </form> 	
<?php } ?>