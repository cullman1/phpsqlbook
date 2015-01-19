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
            $message.="<a href='http://test1.phpandmysqlbook.com/code/chapter6/reset-password.php?email=".$_REQUEST['email']. "&token=".sha1($_REQUEST['email'].date('Y/m/d'))."'>here</a>";           	    		
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


