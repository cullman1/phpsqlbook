<?php
require('../../vendor/PHPMailer/PHPMailerAutoload.php');

function send_email($to, $subject, $message) {
  $mail = new PHPMailer();                               // Create object
  // How the email is going to be sent
  $mail->IsSMTP();                                       // Set mailer to use SMTP
  $mail->Host     = 'secure.emailsrvr.com';                  // SMTP server address
  $mail->SMTPAuth = true;                                // Turn on SMTP authentication
  $mail->Username = 'chris@deciphered.com';              // Username
  $mail->Password = 'CU_Dec23c58y1';                     // Password
  // Who the email is from and to
  $mail->setFrom('test@example.com');                    // From
  $mail->AddAddress($to);                                // To
  // Content of email
  $html = '';    
 $mail->SMTPDebug = 0;                                         // ???
  $mail->Subject = $subject;                             // Set subject of email

  $html_header= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style type="text/css">#outlook a{padding:0}body{width:100%!important}.ReadMsgBody{width:100%}.ExternalClass{width:100%}body{-webkit-text-size-adjust:none}body{margin:0;padding:0}table td{border-collapse:collapse}body{background-color:#efefef}td.message{background-color:#FFF;color:#202020;font-family:Arial;font-size:16px;line-height:150%;padding:20px;text-align:left}a .yshortcuts,a:link,a:visited{color:#096;font-weight:400;text-decoration:underline}</style></head><body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"><center><table border="0" cellpadding="0" cellspacing="0" class="container" height="100%" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="600"><tr><td class="header"><img src="email-header.png" style="max-width:600px"></td></tr><tr><td align="left" class="message">';
     $html_footer= '</td></tr></table></td></tr></table></center></body></html>';
  $mail->Body    = $html_header . $message . $html_footer;   


  $mail->AltBody = $message;                                // Set body to HTML email
  $mail->CharSet = 'UTF-8';                              // Set character set
  $mail->IsHTML(true);                                   // Set email format to HTML
  // Attempt to send email
  if(!$mail->Send()) {
    echo $mail->ErrorInfo;
    return false;
  }
  return true;
}

$email = ( isset($_POST['email']) ? $_POST['email'] : '' ); 
$valid = array('email' => '');
$message = '';
$subject = array('Welcome','Thank you', 'Sorry');
$body = array('Welcome to our web site',
              'Thank you for your donation ',
              'We are sorry to hear you are leaving');
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $valid['email'] = (filter_var($email, FILTER_VALIDATE_EMAIL)) ? '' : 'Email invalid';
  $result = send_email($_POST['email'], $subject[$_POST['template']], 
                       $body[$_POST['template']]);
  if ($result) {
    $message = 'Email sent.';
  } else {
    $message = 'There was a problem with sending the email.';
  }
} ?>
 <form method="post" action="send-email.php">
    <h1>Send an Email</h1>
    <label for="email">Enter Your Email Address:
    <input type="text" id="email" name="email" />
    <div class='error'><?= $valid["email"] ?></div></label><br /><br />
    <label for="email">Select Email Template:
      <select name="template">
        <option value="0">Welcome message</option>
        <option value="1">Thank you message</option>
        <option value="2">Unsubscribe message</option>
      </select>
      </label><br /><br />
    <input type="submit" name="submit" value="Send Message"/>
  </form>
<div class="error"><?= $message ?></div> 
 