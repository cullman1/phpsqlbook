<?php
function send_email($to, $subject, $message) {
try {
  $mail = new PHPMailer(true);                             // Create object
  $mail->IsSMTP();                                         // Set mailer to use SMTP
        $mail->Host     = 'secure.emailsrvr.com';                    // SMTP server address
  $mail->SMTPAuth = true;                                  // SMTP authentication on
  $mail->Username = 'test@deciphered.com';                   // Username
  $mail->Password = 'M3f2gs_egWJF2!';                  // Password
  $mail->setFrom('no-reply@example.com');                  // From
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
require('../vendor/PHPMailer/PHPMailerAutoload.php');        // Include PHPMailer

$to      = 'bob@example.org';                                // To address
$subject = 'Welcome to our website';                         // From address
$message = 'The welcome message goes here';                  // Message

$result  = send_email($to, $subject, $message);              // Try to sent it

if ($result) {                                               // Sent: store success msg
  $alert = Array('status'  => 'success', 'message' => 'Email sent.'); 
} else {                                                     // Not sent: store fail msg
  $alert = Array('status'  => 'danger', 'message' => 'Cannot send email.'); 
}
echo '<div class="' . $alert['status'] . '">' .  $alert['message'] . '</div>';
?>