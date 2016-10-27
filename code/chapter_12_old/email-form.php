<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
include '../includes/header.php';
require_once('classes/email.php'); ?>
<form method="post" action="email-form.php">
<label for="full_name">Enter Your Email Address:</label> 
<input type="text" id="email" name="email" /><br /><br />
<input type="submit" value="Send Test Email" />
<?php if (!empty($_POST["email"])){           
 $to = $_POST['email']; 
  $from = "ech@eastcornwallharriers.com";                                                       
  $subject = "Test";                                                           
 $message = "This is a test message";
 $headers = "MIME-Version: 1.0" . "\r\n";                                                           
  $headers .="Content-type:text/html;charset=UTF-8"."\r\n";
  $headers .="From: Admin<admin@deciphered.com>"."\r\n";                            
 $mail = new Emailer('ech@eastcornwallharriers.com','TVD!nner2',$subject,$message,$from);
 $mail->SentTo($to);                             
 $success = $mail->Send(); 
echo "Test message sent";     
  } ?>     
</form> 
