<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
    require_once('includes/database_connection.php'); 
    require_once('includes/functions.php');
    $show_form = true;
    define ('KEY', 'kE8vew3Jmsvd7Fgh');
    define ('METHOD', 'AES-128-CBC');
    $message = '';
    $valid = array('password' => '', 'confirm'=>'' );
    $password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
    $confirm  = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
    $iv = ( isset($_REQUEST['iv']) ? $_REQUEST['iv'] : '' ); 
    $token  = ( isset($_REQUEST['token'])  ? $_REQUEST['token']  : '' ); 

 function get_user_by_email($email) {
   $query = "SELECT user.id,  forename, surname, email, image FROM user JOIN password on user.id = password.id WHERE email =:email";
   $statement = $GLOBALS['connection']->prepare($query);
   $statement->bindParam(":email", $email);
   $statement->execute();
   $user =   $statement->fetch(PDO::FETCH_OBJ);
   return ($user ? $user : false);
}

function add_password($password, $id){
  $hash = password_hash($password, PASSWORD_DEFAULT);
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

function validate_form($valid, $password, $confirm, $token, $iv) {
  $valid['password'] = (filter_var($password, FILTER_VALIDATE_REGEXP, array("options" =>  array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/"))) ? '' : 'Password not strong');
  $valid['confirm'] = (filter_var($confirm, FILTER_DEFAULT)) ? '' : 'Confirm password';
  if ($valid['password'] == '') {
    $valid['confirm'] = ($password == $confirm ? '' : 'Passwords do not match' );
  }
  return $valid;
}

 function decrypt_token($token, $iv, $valid) {
  $token   = base64_decode($token);
  $iv      = base64_decode($iv);
  $message = openssl_decrypt($token, METHOD, KEY, OPENSSL_RAW_DATA, $iv);
  if (strlen($message)!=0) { 
    $items = explode("#" ,$message);
    if((time() - $items[1]) <= 8400) {
      return  $items[0];
    }
  }
  return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $valid = validate_form($valid, $password, $confirm, $token, $iv );
  $validation_failed = array_filter($valid);
  if ($validation_failed == true) {
      $message = 'Please check errors below and resubmit form';
  } else {
    $message = decrypt_token($token, $iv, $valid);
    if ($message) { 
      $user = get_user_by_email($message);
      if (add_password($password, $user->id)) {
        $show_form = false;
        $message = "Password successfully updated";
      } else {
        $message = "Password not updated";
      } 
    } else {
        $message = "Token invalid";
    } 
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
  <input type="hidden"  name="token" value="<?= $token ?>" />
  <input type="hidden"  name="iv" value="<?= $iv ?>" />
  <input type="submit" name="submit_button" value="Submit New Password" />       						
</form> 					
<?php } ?>