<?php include '../includes/header.php';
    require_once('../includes/database_connection.php'); 
    $show_form = true;
    $valid = array('password' => '', 'confirm'=>'' );
    $password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
    $confirm  = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
    $email = ( isset($_GET['email']) ? $_GET['password'] : '' ); 
    $token  = ( isset($_GET['$token'])  ? $_GET['$token']  : '' ); 

function set_password($pass, $email){
        $preSalt = "54%r!";
          $afterSalt = "5*yL0"; 
  $message = "Password successfully updated!"; 
  $query ="UPDATE Password Set Hash = :pass WHERE id= :id";
  $statement = $GLOBALS['connection']->prepare($query);
  $saltedPass = sha1($preSalt.$pass.$afterSalt);
  $statement->bindParam(":pass", $saltedPass);
  $statement->bindParam(":email", $email);
  $statement->bindParam($query);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  if($statement->errorCode() != 0) {  
    return $statement->errorCode();
  }
  return true;
}

function validate_form($valid, $pass, $confpass) {
  $valid['password'] = (filter_var($password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/"))) ? '': 'Password not strong enough'  );
  $valid['confirm'] = (filter_var($confirm, FILTER_DEFAULT)) ? '' : 'Confirm password';
   $valid['email']    = (filter_var($email,    FILTER_VALIDATE_EMAIL)) ? '' : 'Email invalid';
    $valid['token']    = (filter_var($email,    FILTER_CALLBACK, array("options"=>"check_token"))) ? '' : 'Token expired';
  if ($valid['password'] == '') {
	  $valid['confirm'] = ($password == $confirm ? '' : 'Passwords do not match' );
	}
      return $valid;
}

 function check_token($email, $token) {
 if ( sha1($email.date('Y/m/d')) == $token ) {
  return true;
 } else {
 return false;
 }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $valid = validate_form($valid, $password,$confirm );
  $validation_failed = array_filter($valid);
  if ($validation_failed == true) {
    $message = 'Please check errors below and resubmit form';
	} else {
      set_password($password, $confirm);
      $show_form = false;
      $message = "Password successfully updated";
    }
  }
?>
<body>
<?php require_once('login-menu.php'); ?>
<div class='error indent'><?= $message; ?></div>
<?php if ($show_form == true) { ?>
<form name="input_form" method="post" action="reset-password.php">
  <h1>Reset Your Password</h1>
  <label for="password">Enter Your New Password:</label> 
  <input type="password"  name="password" />
  <label for="confirmpassword">Confirm Your Password:</label> 
  <input type="password"  name="confirmPassword" />
  <input type="hidden" name="email" value="<?= $email ?>" />
  <input type="hidden"  name="token" value="<?= $token; ?>" />
  <input type="submit" name="submit_button" value="Submit New Password" />       						
</form> 					
<?php } ?>