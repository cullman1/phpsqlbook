<?php
require_once "Mail.php";
 function pear_mail($to, $subject, $message, $headers) {


 
$host = "mail.deciphered.com";
$username = "chris@deciphered.com";
$password = "Trecarne_PL145BS";
 
$headers = array ('From' => 'chris@deciphered.com',
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'auth' => true,
    'username' => $username,
    'password' => $password));
 
$mail = $smtp->send($to, $headers, $message);
 
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
} else {
  echo("<p>Message successfully sent!</p>");
}
}
?>