<?php
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
 $message = "This is a test, please ignore";
 $msg = send_mail($to, $subject, $message);
 echo $msg;
} ?>
<form method="post" action="sendmail.php">
<input type="submit" value="Send a message">
</form>