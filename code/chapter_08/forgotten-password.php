<?php include '../includes/header.php';
require_once('../includes/mail1.php');
     function send_email($email) {  
 
  $to = $email; 
  $subject = "Reset Password Link";
  $message = "The link to reset your password is ";
  $message.="<a href='http://test1.phpandmysqlbook.com/login/reset-password.php?email=".$email."&token=".sha1($email.date('Y/m/d'))."'>here<a>"; 
  $headers = "MIME-Version: 1.0"."\r\n";
  $headers.= "Content-type:text/html;charset=UTF-8"."\r\n";
  $headers.= "From: CMS Admin<admin@deciphered.com>"."\r\n"; 
 
  mail($to, $subject, $message, $headers);
    echo "A password reset link has been sent to that email address.";
 
 } ?>
<form method="post" action="forgotten-password.php">
  <h1>Forgotten Your Password?</h1>
  <label for="email">Enter Your Email Address:</label> 
  <input type="text" id="email" name="email" />
  <br /><br />
<input type="submit" name="submit" value="Send Reset Link"/>
 <?php if (!empty($_POST["email"])){ 

  send_email($_POST["email"]); 
} ?>
</div>
</form> 	
<?php include '../includes/footer.php' ?>


