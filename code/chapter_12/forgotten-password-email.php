<?php include '../includes/header.php';
      require_once('../includes/email.php');
      require_once('../includes/db_config.php'); ?>
<form name="input_form" method="post" action="forgotten-password-email.php">
      <div class="wholeform">
      <div ><h1>Online email tool</h1>
          <br /><br />
<label for="full_name">Enter Email Address to send to:</label> 
<input type="text" id="email" name="email" />
          <br /><br />
<label for="message">Enter Message:</label> 
<textarea id="message" name="message" rows="5" cols="100"></textarea>
          <br /><br />
<input type="submit" name="submit_button" value="Send Message" />
       </div>
            <div id="Status_Post">
                   <div id="Div1">
                <?php if (!empty($_REQUEST["email"])){           
                          $to = $_REQUEST['email'];                                                        
                          $subject = "Reset Password Link";                                                           
                          $message = $_REQUEST['email'];
                          $headers = "MIME-Version: 1.0" . "\r\n";                                                           
                          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";                           
                          $headers .= 'From: CMS Admin <admin@deciphered.com>' . "\r\n";                               
                          $mail = new simple_emailer();
                          $mail->username = 'ech@eastcornwallharriers.com'; // Must exist in Control panel
                          $mail->password = 'TVD!nner2';
                          $mail->SentFrom("ech@eastcornwallharriers.com","ECH Admin");  // Name is optional   
                          $mail->SentTo($to);
                          $mail->subject = $subject;
                          $mail->message = $message;
                          $mail->ContentType = "text/html";          // Defaults to "text/plain; charset=iso-8859-1"
                          $mail->ConnectTimeout = 60;  // Socket connect timeout (sec)
                          $mail->ResponseTimeout = 18;  // CMD response timeout (sec)
                          $success = $mail->Send();      
                          echo "<br/>Message sent.";  
                      } 											
                ?>        
           </div>									
      </div>									
</form> 								
<?php include '../includes/footer.php' ?>