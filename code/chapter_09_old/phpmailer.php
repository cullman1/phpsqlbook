<?php
require('../vendor/PHPMailer/PHPMailerAutoload.php');
try {
  $mail = new PHPMailer(true);                               // Create object
  // Step 2: How the email is going to be sent
  $mail->IsSMTP();                                       // Set mailer to use SMTP
   $mail->Host     = 'secure.emailsrvr.com';                    // SMTP server address
  $mail->SMTPAuth = true;                                  // SMTP authentication on
  $mail->Username = 'test@deciphered.com';                   // Username
  $mail->Password = 'M3f2gs_egWJF2!';                            // Password

  // Step 3: Who the email is from and to
  $mail->setFrom('ivy@example.com', 'Ivy Stone');        // From (name optional)
  $mail->addReplyTo('help@example.com', 'Support');      // From (name optional)
  $mail->addAddress('chrisullman@btinternet.com', 'Chris White'); // To   (name optional)
  $mail->addAddress('chrisullman@tiscali.co.uk', 'Tom Dee');       // To   (name optional)
  $mail->addCC('chrisull@hotmail.co.uk');                       // CC   (name optional)
  $mail->addBCC('salondadasiegt@gmail.com');                     // BCC  (name optional)
  // Step 4: Content of email
  $message       = 'This is a test email';                  // Message(can contain HTML)
  $mail_header   = '<!DOCTYPE html PUBLIC...';              // Header goes here
  $mail_footer   = '...</html>';                            // Header goes here
  $mail->Subject = 'This is the subject of the email';       // Set subject of email
  $mail->Body    = $mail_header . $message . $mail_footer;  // Set body to HTML email
  $mail->AltBody = strip_tags($message);                    // Set plain text version
  $mail->CharSet = 'UTF-8';                                 // Set character set
  $mail->IsHTML(true);                                      // Set it to be an HTML mail
  // Step 5: Attempt to send email
  $message = $mail->Send();                                 // Send message
} catch (phpmailerException $e) {
  echo $e->errorMessage();                               //Error messages from PHPMailer
} 
if ($message) {
  echo 'Message Sent';
}