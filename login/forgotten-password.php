<?php include '../includes/header.php';
      require_once('../includes/db_config.php'); ?>
<form name="input_form" method="post" action="forgotten-password.php">
      <div class="wholeform">
      <div ><h1>Forgotten Your Password?</h1>
          <br /><br />
<label for="full_name">Enter Your Email Address:</label> 
<input type="text" id="email" name="email" />
          <br /><br />
<input type="submit" name="submit_button" value="Send Reset Link" />
       </div>
            <div id="Status_Post">
                   <div id="Div1">
                <?php if (!empty($_REQUEST["email"])){           
                    $to = $_REQUEST['email'];                                                        
                    $subject = "Reset Password Link";                                                           
                    $message = "The link to reset your password is ";
            $message.="<a href='http://test1.phpandmysqlbook.com/login/reset-password.php?email=".$_REQUEST['email']. "&token=".sha1($_REQUEST['email'].date('Y/m/d'))."'>here</a>";           	    		
                    $headers = "MIME-Version: 1.0" . "\r\n";                                                           
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";                           
                    $headers .= 'From: CMS Admin <admin@deciphered.com>' . "\r\n";                            
                    mail($to, $subject, $message, $headers);                                           
                    echo "<br/>A link to reset your password has been emailed to that address.";  
            
                } 											
                ?>        
                   </div>									
      </div>									
</form> 								
<?php include '../includes/footer.php' ?>

[mail function]
; XAMPP: Comment out this if you want to work with an SMTP Server like Mercury
; SMTP = localhost
smtp_port = 25

; For Win32 only.
; http://php.net/sendmail-from
sendmail_from = postmaster@localhost

; XAMPP IMPORTANT NOTE (1): If XAMPP is installed in a base directory with spaces (e.g. c:\program filesC:\xampp) fakemail and mailtodisk do not work correctly.
; XAMPP IMPORTANT NOTE (2): In this case please copy the sendmail or mailtodisk folder in your root folder (e.g. C:\sendmail) and use this for sendmail_path.  
 
; XAMPP: Comment out this if you want to work with fakemail for forwarding to your mailbox (sendmail.exe in the sendmail folder)
;sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

; XAMPP: Comment out this if you want to work with mailToDisk, It writes all mails in the C:\xampp\mailoutput folder
sendmail_path = "C:\xampp\mailtodisk\mailtodisk.exe"

; Force the addition of the specified parameters to be passed as extra parameters
; to the sendmail binary. These parameters will always replace the value of
; the 5th parameter to mail(), even in safe mode.
;mail.force_extra_parameters =

; Add X-PHP-Originating-Script: that will include uid of the script followed by the filename
mail.add_x_header = Off

; Log all mail() calls including the full path of the script, line #, to address and headers
;mail.log = "C:\xampp\php\logs\php_mail.log"
