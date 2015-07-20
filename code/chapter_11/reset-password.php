<?php include '../includes/header.php';
      require_once('../includes/db_config.php'); ?>
<form name="input_form" method="post" action="reset-password.php">
     <h1>Reset Your Password</h1><br /><br />
<label for="password">Enter Your New Password:
<input type="password" id="password" name="password" /></label> 
<label for="confirmpassword">Confirm Your Password:
<input type="password" id="confirmpassword" name="confirmpassword" /></label> 
<input type="hidden" id="email" name="email" value="<?php  if (!empty($_POST['email'])) { echo $_POST['email']; } else { throw new Exception ("<br/>Email missing!");}  ?>" />
<input type="hidden" id="token" name="token" value="<?php  if (!empty($_POST['token'])) { echo $_POST['token']; } else { throw new Exception ("<br/>Token missing!");}  ?>" />
<input type="submit" name="submit_button" value="Submit New Password" />
<?php try {         
if (!empty($_POST['password'])){                            
if ($_POST["password"]!=$_POST["confirmpassword"]) {
  throw new Exception ("<br/>Passwords do not match!");
}  
if (!preg_match("#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_POST['password'])) {
  throw new Exception ("<br/>Password was not strong enough. >Your password must contain at least one alphanumeric, one digit and one non-alpha-numeric character.");  
}
if ( sha1($_POST['email'].date('Y/m/d')) == $_POST['token'] ) {        
  $update_user_result = $dbHost->prepare("UPDATE user Set Password = :password . WHERE email= :email");
  $password = sha1($preSalt.$_POST['password'].$afterSalt);  
  $update_user_result->bindParam(":password", $password ) ; 
  $update_user_result->bindParam(":email", $_POST['email'] ) ;                            
  $update_user_result->execute();
  if($update_user_result->errorCode() != 0) {  
    throw new Exception ("<br/>Password was not updated, please request a new link."); 
  }
 } else {
   throw new Exception ("<br/>Tokens do not match, please request a new link and try again."); 
 }
 echo "<br/>Password successfully updated!"; 
 } 
} catch (Exception $ex) {
                    echo $ex->getMessage();
} ?>        						
</form> 								
<?php include '../includes/footer.php' ?>