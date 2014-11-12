<?php include '../includes/header-register.php';
      require_once('../includes/db_config.php'); ?>
<form name="input_form" method="post" action="forgotten-password.php">
      <div class="wholeform">
      <div class="col-md-4"><h1>Forgotten Your Password?</h1>
<label for="full_name">Enter Your Email Address:</label> 
<input type="text" id="email" name="email" /><br />
<input type="submit" name="submit_button" value="Send Password" />
       </div>
            <div id="Status_Post">
        <?php
        if (!empty($_REQUEST["email"])){           
            $select_user_sql = "SELECT  * from user WHERE email ='".$_REQUEST['email']."'";            
            $select_user_result = $dbHost->prepare($select_user_sql);
            $select_user_result->execute();
            $select_user_result->setFetchMode(PDO::FETCH_ASSOC);
            while($select_user_row = $select_user_result->fetch()) { 
                $to = $_REQUEST['email'];                                                        
                $subject = "Reset Password Link";                                                           
                $message = "The link to reset your password is";
                $message.="<a href= http://test1.phpandmysqlbook.com/login/reset-password.php?email=" .$_REQUEST['email']. "&token=".sha1($_REQUEST['email'].date('Y/m/d'))."'>here</a>";           
                $headers = "MIME-Version: 1.0" . "\r\n";                                                           
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";                             
                mail($to, $subject, $message, $headers);                                           
                echo "<br/>A link to reset your password has been emailed to that address.";
            }
        } 											?>										

            </div>									

      </div>									

</form> 								
<?php include '../includes/footer.php' ?>
