<?php
require_once "Mail.php";
require_once "Mail/mime.php";
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
    mail($to, $subject, $message);
    return "Message sent";  
  }
  catch (Exception $e) {
  return "Message failed: " .$e->getMessage();  
  }
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
  if (isset($_POST["mandrillmail"])) {     
   $message ="This is a test using mandrill";
   $msg = mandrill($to, $subject,$message);
  }
  echo $msg;
} ?>
<form method="post" action="sendmail.php">
<input type="submit" name="mandrillmail" value="Send a message with Mandrill Mail">
<input type="submit" name="pearmail" value="Send a message with Pear mail">
<input type="submit" name="sendmail" value="Send a message with Sendmail">
</form>