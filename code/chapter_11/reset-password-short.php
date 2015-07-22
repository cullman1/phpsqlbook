<?php include '../includes/header.php';
 require_once('../includes/db_config.php'); ?>
<form method="post" action="reset-password-short.php">
<h1>Reset Your Password</h1><br /><br />
<label for="password">Enter Your New Password:
<input type="password" name="password" /></label> 
<input type="hidden" id="email" name="email" value="<?php  if (!empty($_REQUEST['email'])) { echo $_REQUEST['email']; }   ?>" />
<input type="hidden" id="token" name="token" value="<?php  if (!empty($_REQUEST['token'])) { echo $_REQUEST['token']; }   ?>" />
<input type="submit" value="Submit New Password" />
<?php try {         
if (!empty($_POST['password'])){                            
if (!preg_match("#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#", $_POST['password'])) {
  throw new Exception ("<br/>Password must contain one alphanumeric, one digit and one upper case char.");  
}

if (hash('sha256',trim($_POST['email']).date('Y/m/d')) ==$_POST['token'] ) {        
  $update_user_result = $dbHost->prepare("UPDATE user Set Password = :password  WHERE email= :email");
  $password = sha1($preSalt.$_POST['password'].$afterSalt);  
  $update_user_result->bindParam(":password", $password ) ; 
  $update_user_result->bindParam(":email", $_POST['email']);                            
  $update_user_result->execute();
  if($update_user_result->errorCode() != 0) {  
  throw new Exception("Password not updated, try again."); 
  }
 } else {
  throw new Exception("Link has expired,please try again."); 
 }
 echo "<br/>Password successfully updated!"; 
 } 
} catch (Exception $ex) { echo $ex->getMessage();} ?>   
</form> 			
<?php include '../includes/footer.php' ?>


