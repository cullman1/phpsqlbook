<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
    require_once('includes/database_connection.php'); 
    $show_form = true;
    $message = '';
    $valid = array('password' => '', 'confirm'=>'' );
    $password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
    $confirm  = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
    $email = ( isset($_REQUEST['email']) ? $_REQUEST['email'] : '' ); 
    $iv = ( isset($_REQUEST['iv']) ? $_REQUEST['iv'] : '' ); 
    $token  = ( isset($_REQUEST['token'])  ? $_REQUEST['token']  : '' ); 

 function get_user_by_email($email) {
   $query = "SELECT * from user WHERE email = :email";
   $statement = $GLOBALS['connection']->prepare($query);
   $statement->bindParam(":email", $email);
   $statement->execute();
   $user =   $statement->fetch(PDO::FETCH_OBJ);
   return ($user ? $user : false);
}

function hash_password($password) {
									$pwdToken = sha1("abD!y1" . $password . "d!@gg3");
									//$hash = password_hash($pwdToken); 
									return $pwdToken;
}



function set_password($pass, $id){
  $hash = hash_password($pass);
  $query ="UPDATE password set hash = :pass WHERE id= :id";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(":pass", $hash);
  $statement->bindParam(":id", $id);
  $statement->execute();
  if($statement->errorCode() != 0) {  
    return $statement->errorCode();
  }
  return true;
}

function validate_form($valid, $password, $confirm, $email, $token, $iv) {
  $valid['password'] = (filter_var($password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/"))) ? '': 'Password not strong enough'  );
  $valid['confirm'] = (filter_var($confirm, FILTER_DEFAULT)) ? '' : 'Confirm password';
  $valid['email']    = (filter_var($email,    FILTER_VALIDATE_EMAIL)) ? '' : 'Email invalid or missing';    
$valid['token']    = (filter_var($token,    FILTER_DEFAULT)) ? '' : 'Token invalid';
$valid['iv']    = (filter_var($iv,    FILTER_DEFAULT)) ? '' : 'IV invalid';
  if ($valid['password'] == '') {
	  $valid['confirm'] = ($password == $confirm ? '' : 'Passwords do not match' );
	}
     if ($valid['token'] == '') {
	 $valid = decrypt_data($token, $iv, $valid);
	}
      return $valid;
}

 function decrypt_data($token, $iv, $valid) {
   $token2 = base64_decode($token);
   $iv2 = base64_decode($iv); 
   $key = 'ThisIsACipherKey';
   $decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $token2, MCRYPT_MODE_CBC, $iv2);
   if (strlen($decrypted_string)==0) { 
     $valid['token']="Token invalid";
   } else {
     $checker = explode("#" ,$decrypted_string);
     if((time() - $checker[1]) > 8400) {
       $valid['token']="Token expired";
     } 
   }
   return $valid;
 }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $valid = validate_form($valid, $password,$confirm, $email, $token, $iv );
  $validation_failed = array_filter($valid);
  if ($validation_failed == true) {
    if ($valid['email'] != '') {
          $message = $valid['email'];
    }
    else if ($valid['token'] != '') {
          $message = $valid['token'];
    } else {
        $message = 'Please check errors below and resubmit form';
    }
} else {
      $user = get_user_by_email($email);
      set_password($password, $user->id);
      $show_form = false;
      $message = "Password successfully updated";
    }
  }
?>
<body>
<?php require_once('login-menu.php'); ?>
<div class='error indent'><?= $message; ?></div>
<?php if ($show_form == true) { ?>
<form name="input_form" method="post" action="reset-password-new.php">
  <h1>Reset Your Password</h1>
  <label for="password">Enter Your New Password:
  <input type="password"  name="password" /> <div class='error'><?= $valid["password"] ?></div></label> 
  <label for="confirmpassword">Confirm Your Password:
  <input type="password"  name="confirm" /> <div class='error'><?= $valid["confirm"] ?></div></label> 
  <input type="hidden" name="email" value="<?= $email ?>" />
  <input type="hidden"  name="token" value="<?= $token ?>" />
  <input type="hidden"  name="iv" value="<?= $iv ?>" />
  <input type="submit" name="submit_button" value="Submit New Password" />       						
</form> 					
<?php } ?>