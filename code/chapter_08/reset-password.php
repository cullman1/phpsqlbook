<?php include '../includes/header.php';
      require_once('../includes/db_config.php'); 
function set_password($dbHost,$pass,$confpass,$preSalt,$afterSalt){
  $message = "Password successfully updated!"; 
  $query ="UPDATE user Set Password = :pass WHERE email= :email";
  $statement = $dbHost->prepare($query);
  $saltedPass = sha1($preSalt.$pass.$afterSalt);
  $statement->bindParam(":pass", $saltedPass);
  $statement->bindParam(":email", $email);
  $statement->bindParam($query);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  if($statement->errorCode() != 0) {  
   $message="Password not updated, please request new link"; 
  }
  return $message;
}

function validate_form($pass, $confpass) {
$message="true";
if ($pass!=$confpass) {
    $message ="Passwords do not match!";
  }  
  $reg="#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]) (?=.*\W).*$#";
  if (!preg_match($reg, $pass)) {
   $message = "Password was not strong enough. Your password must contain at least one alphanumeric, one digit and one non-alpha-numeric character.";  
  }
  return $message;
}

 function check_token($email, $token) {
 if ( sha1($email.date('Y/m/d')) == $token ) {
  return true;
 } else {
 return false;
 }
}

if (check_token($_GET["email"], $_GET["token"])) { ?>
<form name="input_form" method="post" action="reset-password.php">
  <h1>Reset Your Password</h1>
  <label for="password">Enter Your New Password:</label> 
  <input type="password"  name="password" />
  <label for="confirmpassword">Confirm Your Password:</label> 
  <input type="password"  name="confirmPassword" />
  <input type="hidden" name="email" value="<?php echo $_GET['email'];  ?>" />
  <input type="hidden"  name="token" value="<?php echo $_GET['token'];  ?>" />
  <input type="submit" name="submit_button" value="Submit New Password" />
  <?php  if (validate_form(filter_input(INPUT_POST, 'password'), filter_input(INPUT_POST,'confirmPassword')=="true"))  {            
          $preSalt = "54%r!";
          $afterSalt = "5*yL0";                
          set_password($dbHost,$_POST['password'], $_POST['confirmPassword'], $preSalt, $afterSalt);
          } ?>        						
</form> 		
<?php } else {
echo "Token has expired or is incorrect, please request a new link";
} ?>						
<?php include '../includes/footer.php' ?>