<?php include '../includes/header.php';
      require_once('../includes/db_config.php'); ?>
<form name="input_form" method="post" action="reset-password.php">
      <div class="wholeform">
      <div ><h1>Reset Your Password</h1>
          <br /><br />
<label for="v">Enter Your New Password:</label> 
<input type="password" id="password" name="password" />
          <br /><br />
          <label for="confirmpassword">Confirm Your Password:</label> 
<input type="confirmpassword" id="confirmpassword" name="confirmpassword" />
          <input type="hidden" id="email" name="email" value="<?php  if (!empty($_REQUEST['email'])) { echo $_REQUEST['email']; } else { throw new Exception ("<br/>Email missing!");}  ?>" />
          <input type="hidden" id="token" name="token" value="<?php  if (!empty($_REQUEST['token'])) { echo $_REQUEST['token']; } else { throw new Exception ("<br/>Token missing!");}  ?>" />
          <br /><br />
<input type="submit" name="submit_button" value="Submit New Password" />
       </div>
            <div id="Status_Post">
                <?php 
                try {         
                    if (!empty($_REQUEST['password'])){                            
                        if ($_REQUEST["password"]!=$_REQUEST["confirmpassword"]) {
                            throw new Exception ("<br/>Passwords do not match!");
                        }  
                        if (!preg_match("#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_REQUEST['password'])) {
                            throw new Exception ("<br/>Password was not strong enough. >Your password must contain at least one alphanumeric, one digit and one non-alpha-numeric character.");  
                        }
                        if ( sha1($_REQUEST['email'].date('Y/m/d')) == $_REQUEST['token'] ) {
                            $update_user_sql = "UPDATE user Set Password = '".sha1($preSalt.$_REQUEST['password'].$afterSalt)."' WHERE email='".$_REQUEST['email']."'";            
                            $update_user_result = $dbHost->prepare($update_user_sql);
                            $update_user_result->execute();
                            $update_user_result->setFetchMode(PDO::FETCH_ASSOC);
                            if($update_user_result->errorCode() != 0) {  
                                throw new Exception ("<br/>Password was not updated, please request a new link."); 
                            }
                        }
                        else {
                            throw new Exception ("<br/>Tokens do not match, please request a new link and try again."); 
                        }
                        echo "<br/>Password successfully updated!"; 
                    } 
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                } ?>        						
      </div>									</form> 								
<?php include '../includes/footer.php' ?>