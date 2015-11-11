<?php
require_once "Mail.php";
require_once "Mail/mime.php";
 function pear_mail($to, $subject, $html, $headers) {
$host = "mail.deciphered.com";
$username = "chris@deciphered.com";
$password = "Trecarne_PL145BS";
$headers = array ('From' => 'chris@deciphered.com',
  'To' => $to,
  'Subject' => $subject);
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
?>