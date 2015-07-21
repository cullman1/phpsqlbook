<?php include '../includes/header.php';

  require_once('../includes/db_config.php');
 require_once('classes/email.php'); ?>
<form method="post" action="forgotten-password-short.php">
  <h1>Forgotten Your Password?</h1><br /><br />
  <label for="full_name">Enter Your Email Address:</label> 
  <input type="text" id="email" name="email" /><br /><br />
  <input type="submit" value="Send Reset Link" />
 <?php if (!empty($_POST["email"])){           
   $to = $_POST['email'];                                                        
    $subject = "Reset Password Link";                                                           
    $message = "The link to reset your password is ";
    $message.="<a href='http://test1.phpandmysqlbook.com/code/chapter_11/reset-password-short.php?email=".$_POST['email']." &token=".sha1(trim($_POST['email']).date('Y/m/d'))."'>here</a>";   
$headers = "MIME-Version: 1.0" . "\r\n";                                                           
   $headers .="Content-type:text/html;charset=UTF-8"."\r\n";
    $headers .="From: Admin<admin@deciphered.com>"."\r\n";                            
    $mail = new Emailer;
    $mail->user = 'ech@eastcornwallharriers.com'; 
    $mail->password = 'TVD!nner2';
    $mail->SentFrom("ech@eastcornwallharriers.com","Admin");   
    $mail->SentTo($to); 
    $mail->subject = $subject;
    $mail->message = $message;
    $mail->contentType = "text/html";          
    $mail->connectTimeout =60;
    $mail->responseTimeout = 18;                               
    $success = $mail->Send();      
    if ($success=="true") { 
      echo "<br/>A password reset link has been emailed.";     
    }   else {
    echo "<br/>An error has occurred: ".$success;     
    }
  } ?>     
</form> <?php include '../includes/footer.php' ?>


