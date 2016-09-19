<?php
// Step 1: Include script and create object
require('../vendor/PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer();                               // Create object

// Step 2: How the email is going to be sent
$mail->IsSMTP();                                       // Set mailer to use SMTP
$mail->Host     = 'secure.emailsrvr.com';                  // SMTP server address
$mail->SMTPAuth = true;                                // Turn on SMTP authentication
$mail->Username = 'placeholder@deciphered.com';                 // Username
$mail->Password = 'placeholder';                          // Password

// Step 3: Who the email is from and to
$mail->setFrom('test@deciphered.com', 'Ivy Stone');        // From (name optional)
$mail->addReplyTo('test@deciphered.com', 'Support');      // From (name optional)
$mail->addAddress('chris@deciphered.com', 'Chris White'); // To   (name optional)
$mail->addAddress('chris@deciphered.com', 'Tom Dee');       // To   (name optional)
$mail->addCC('chris@deciphered.com');                       // CC   (name optional)
$mail->addBCC('chris@deciphered.com');                     // BCC  (name optional)

$message       = 'This is a test email';                  // Message (can contain HTML)
 $mail_header= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style type="text/css">#outlook a{padding:0}body{width:100%!important}.ReadMsgBody{width:100%}.ExternalClass{width:100%}body{-webkit-text-size-adjust:none}body{margin:0;padding:0}table td{border-collapse:collapse}body{background-color:#efefef}td.message{background-color:#FFF;color:#202020;font-family:Arial;font-size:16px;line-height:150%;padding:20px;text-align:left}a .yshortcuts,a:link,a:visited{color:#096;font-weight:400;text-decoration:underline}</style></head><body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"><center><table border="0" cellpadding="0" cellspacing="0" class="container" height="100%" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="600"><tr><td class="header"><img src="email-header.png" style="max-width:600px"></td></tr><tr><td align="left" class="message">';
  $mail_footer= '</td></tr></table></td></tr></table></center></body></html>';                         // Header goes here
$mail->Subject = 'This is the subject of the email';       // Set subject of email
$mail->Body    = $mail_header . $message . $mail_footer;  // Set body to HTML email
$mail->AltBody = strip_tags($message);                    // Set plain text version
$mail->CharSet = 'UTF-8';                                 // Set character set
$mail->IsHTML(true);                                      // Set it to be an HTML mail

// Step 5: Attempt to send email
$mail->SMTPDebug = 0;                                     // Debug option
if(!$mail->Send()) {                                      // Try to send email
  echo $mail->ErrorInfo;                                  // If error, writes that out
} else {                                                  // Otherwise
  echo 'Email has been sent';                             // Success message
}
?>