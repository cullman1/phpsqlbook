<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database_connection.php'); 
require_once('../../vendor/PHPMailer/PHPMailerAutoload.php');
define ('KEY', 'kE8vew3Jmsvd7Fgh');
define ('METHOD', 'AES-128-CBC');
$GLOBALS["SMTPHost"] = "secure.emailsrvr.com";
$GLOBALS["Username"] = "chris@deciphered.com"; //"test@deciphered.com";  	// username
$GLOBALS["Password"] = "CU_Dec23c58y1"; //"Trecarne_PL145BS"; 	
   $show_form = true;
   $message = '';

     $method = 'AES-128-CBC';
   $valid = array('email' => '');
   $email = ( isset($_POST['email']) ? $_POST['email'] : '' ); 
   $valid['email'] = (filter_var($email,    FILTER_VALIDATE_EMAIL)) ? '' : 'Email invalid or missing';

   function send_system_email($to,$from, $from_name,$subject, $html) {
    
    $mail = new PHPMailer();
     $mail->IsSMTP();                                      // set mailer to use SMTP
    $mail->Host = $GLOBALS["SMTPHost"];  // specify main and backup server
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = $GLOBALS["Username"];  // SMTP username
    $mail->Password = $GLOBALS["Password"]; // SMTP password
    $mail->AddAddress($to);   
    $mail->From = $from;
    $mail->FromName = $from_name;
    $mail->IsHTML(true);                                  // set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $html;

    if(!$mail->Send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return  false;
    }

    return true;
}

	function create_iv() {
				$isItSecure = false;
  while ($isItSecure == false) {
    $iv = openssl_random_pseudo_bytes(16, $isItSecure);
    if ($isItSecure) {
      return $iv;
    } 
  }

					}

 if ($email){ 
  $iv =   create_iv();
    $token = $email."#".time();
  $encrypt   = rawurlencode(base64_encode(openssl_encrypt($token, METHOD, KEY, OPENSSL_RAW_DATA, $iv)));
  $iv = rawurlencode(base64_encode($iv));
  $subject = "Reset Password Link";
  $from = "morton@example.org";
  $from_name = "Morton Example";
  $message="<a href='http://test1.phpandmysqlbook.com/code/chapter_09/reset-password-new.php?token=".$encrypt."&iv=".$iv."'>Reset your password<a>"; 
  $message_success = send_system_email($email, $from, $from_name, $subject, $message);
  if ($message_success == true) {
    $message = 'A password reset link has been sent to that email address.';
    $show_form = false;
  } else {
	$message =  'Sorry, we could not reset your password at this time';
  }
 } 
 include 'login-menu.php';
if ($show_form) { ?>
<form method="post" action="forgotten-password.php">
  <h1>Forgotten Your Password?</h1>
  <label for="email">Enter Your Email Address:
  <input type="text" id="email" name="email" /></label> 
  <br /><br />
<input type="submit" name="submit" value="Send Reset Link"/>
</div>
</form> 	
<?php } ?>
  <div class="error"><?= $message ?></div>


