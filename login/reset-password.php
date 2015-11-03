<?php include '../includes/header.php';
      require_once('../includes/db_config.php'); 
function set_password($dbHost,$pass,$email,$preSalt,$afterSalt){
  $message = "Password successfully updated!"; 
  $query ="UPDATE user Set Password = :pass WHERE email= :email";
  $statement = $dbHost->prepare($query);
  $saltedPass = sha1($preSalt.$pass.$afterSalt);
  $statement->bindParam(":pass", $saltedPass);
  $statement->bindParam(":email", $email);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  if($statement->errorCode() != 0) {  
   $message="Password not updated, please request new link"; 
  }
  return $message;
}

function validate_form($pass, $confpass) {
if ($pass!=$confpass) {
     return "Passwords do not match!";
  }  
  $reg="#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]) (?=.*\W).*$#";
  if (!preg_match($reg, $pass)) {
   return "Password was not strong enough.Your password must contain at least one alphanumeric, one digit and one non-alpha-numeric character.";  
  }
  return "true";
}

 function check_token($email, $token) {
   if ( sha1($email.date('Y/m/d')) == $token ) {
     return true;
   } else {
     return false;
   }
 }

  if (check_token(filter_input(INPUT_GET,'email'), filter_input(INPUT_GET,'token')) || $_SERVER['REQUEST_METHOD'] == 'POST') { ?>
  <form name="input_form" method="post" action="reset-password.php">
  <h1>Reset Your Password</h1>
  <label for="pass">Enter Your New Password:</label> 
  <input type="password" id="pass" name="pass" /><br/><br/>
  <label for="confPass">Confirm Your Password:</label> 
  <input type="password"  name="confPass" /><br/><br/>
  <input type="hidden" name="email" value="<?php echo $_GET['email'];  ?>" />
  <input type="submit" name="submit_button" value="Submit New Password" /> 
  </form> 
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $msg = validate_form(filter_input(INPUT_POST,'pass'),filter_input(INPUT_POST,'confPass'));
        if ($msg=="true")  {            
            $preSalt = "54%r!";
            $afterSalt = "5*yL0";                
            $msg = set_password($dbHost,$_POST['password'], $_POST['email'], $preSalt, $afterSalt);
        }
        echo $msg; 		
      } 
    } else {
        echo "Token has expired or is incorrect, please request a new link";
    } ?>			
<?php include '../includes/footer.php' ?>