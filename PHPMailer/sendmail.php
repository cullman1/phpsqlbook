<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once "Mail.php";
require_once "Mail/mime.php";
require("../../PHPMailer/PHPMailerAutoload.php");
function pear_mail($to, $subject, $html, $headers) {
$host = "mail.deciphered.com";
$username = "chris@deciphered.com";
$password = "Trecarne_PL145BS";
$headers = array ('From' => 'chris@deciphered.com','To' => $to, 'Subject' => $subject);
  $message = new Mail_mime();
  $message->setHTMLBody($html);
  $smtp = Mail::factory('smtp',
  array ('host' => $host,
    'auth' => true,
    'username' => $username,
    'password' => $password));

    $mail = $smtp->send($to, $headers, $message->get());
 
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>"); 
} else {  
 echo("<p>Message successfully sent!</p>");
}
}

function mandrill($to, $subject, $html, $headers) {
$host = "smtp.mandrillapp.com";
$username = "chrisullman@btinternet.com";
$password = "znLl-LbahOooVlk-MQ1wkQ";
 $port = "587";
$headers = array ('From' => 'chrisullman@btinternet.com','To' => $to, 'Subject' => $subject);
  $message = new Mail_mime();
  $message->setHTMLBody($html);
  $smtp = Mail::factory('smtp',
  array ('host' => $host,
    'auth' => true,
    'port' => $port,
    'username' => $username,
    'password' => $password));
$mail = $smtp->send($to, $headers, $message->get());
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
} else {
  echo("<p>Message successfully sent!</p>");
}
}

function send_mail($to,$subject,$message) {
  try {
      $headers 	= "From:bob@example.org \r\n";
      $headers 	.= "Content-type:text/html \r\n";
      $headers 	.= "charset:UTF-8 \r\n"; 
      $hash = mail($to, $subject, $message,$headers);
    return $hash."Message sent";  
  }
  catch (Exception $e) {
  return "Message failed: " .$e->getMessage();  
  }
}

function phpmailer($to, $subject, $html) {
    
    $mail = new PHPMailer();
    $mail->IsSMTP();                                      // set mailer to use SMTP
    $mail->Host = "secure.emailsrvr.com";  // specify main and backup server
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = "chris@deciphered.com";  // SMTP username
    $mail->Password = "Trecarne_PL145BS"; // SMTP password
    $mail->AddAddress($to);   
    $mail->From = "bob@example.org";
    $mail->IsHTML(true);                                  // set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $html;

    if(!$mail->Send()) {
        
        return  "Message not sent, Error: " . $mail->ErrorInfo;
    }

    return "Message has been sent";
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $to = "chris@deciphered.com";
  $subject = "Testing";        
  $msg = "";
  if (isset($_POST["sendmail"])) {                                                         
   $message ="This is a test using sendmail";
   $msg = send_mail($to, $subject, $message);
  } 
  if (isset($_POST["pearmail"])) {                                                         
    $message ="This is a test using pear mail";
    $msg = pear_mail($to, $subject, $message);
  }  
  if (isset($_POST["PHPMailer"])) {                                                         
      $message ="This is a test using PHP Mailer";
      $msg = phpmailer($to, $subject, $message);
  }  
  if (isset($_POST["mandrillmail"])) {     
   $message ="This is a test using mandrill";
   $msg = mandrill($to, $subject,$message);
  }
  echo $msg;
} ?>
<form method="post" action="sendmail.php">
<input type="submit" name="mandrillmail" value="Send a message with Mandrill Mail">
<input type="submit" name="pearmail" value="Send a message with Pear mail">
<input type="submit" name="PHPMailer" value="Send a message with PHPMailer">
<input type="submit" name="sendmail" value="Send a message with Sendmail">
</form>