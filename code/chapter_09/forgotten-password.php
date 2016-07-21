<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database_connection.php'); 
require_once('../../vendor/PHPMailer/PHPMailerAutoload.php');

   $show_form = true;
   $message = '';
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
        
        return  false;
    }

    return true;
}

	function create_iv() {
						$iv_size 	= mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,MCRYPT_MODE_CBC);
 						$iv 			= mcrypt_create_iv($iv_size, MCRYPT_RAND);
  					return $iv;
					}

function encrypt_data($token, $iv) {
  $key = 'kE8vew3Jmsvd7Fgh';
  $encrypted_token = mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$key , $token, MCRYPT_MODE_CBC, $iv);
  return base64_encode($encrypted_token);
}

 if ($email){ 
  $iv =   create_iv();
    $token = $email."#".time();
  $encrypted_token = encrypt_data($token, $iv);
  $iv = rawurlencode(base64_encode($iv));
  $subject = "Reset Password Link";
  $from = "morton@example.org";
  $from_name = "Morton Example";
  $message="<a href='http://test1.phpandmysqlbook.com/code/chapter_09/reset-password-new.php?token=".$token."&iv=".$iv."'>Reset your password<a>"; 
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


