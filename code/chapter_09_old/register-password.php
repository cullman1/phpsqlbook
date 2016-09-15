<?php  
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database_connection.php'); 

$show_form = true;
$message = '';
$valid = array('forename' => '', 'surname' =>'', 'email' => '', 'password' => '', 'confirm'=>'' );
$forename = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname  = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm  = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 

function validate_form($forename,$surname,$email,$password,$confirm, $valid){
  $valid['forename'] = (filter_var($forename,  FILTER_DEFAULT))? ''   : 'Enter forename' ;
  $valid['surname'] = (filter_var($surname,  FILTER_DEFAULT)) ? ''  : 'Enter surname' ;
  $valid['email']    = (filter_var($email,    FILTER_VALIDATE_EMAIL))   ? '' : 'Enter email' ;
  $valid['password'] = (filter_var($password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/"))) ? '': 'Password not strong enough'  );
  $valid['confirm'] = (filter_var($confirm, FILTER_DEFAULT)) ? '' : 'Confirm password';
  if ($valid['password'] == '') {
	  $valid['confirm'] = ($password == $confirm ? '' : 'Passwords do not match' );
	}
  if ($valid['email'] == '') {
    $user_exists = get_user_by_email($email);
    if ($user_exists == true) {
      $valid['email'] = 'User already exists';
  	}
  }
  return $valid;
}

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

function add_user($forename, $surname, $password, $email) {     
  $query = "INSERT INTO user (forename, surname, email, password) 
            VALUES (:forename, :surname, :email, :password)";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(":forename", $forename );
  $statement->bindParam(":surname", $surname );
  $statement->bindParam(":email",$email);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $statement->bindParam(":password",$hash);
  $result = $statement->execute();
  if( $result == true ) {     
      return true;
  } else {
      return $statement->errorCode();
  }	   
 }


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $valid = validate_form($forename,$surname,$email,$password,$confirm, $valid);
  $validation_failed = array_filter($valid);
  if ($validation_failed == true) {
  $message = 'Please check errors below and resubmit form';
	} else {
     $user_added = true; 
     $user_added = add_user($forename, $surname, $password, $email);						// Try to add user
    if ($user_added == true) {          // If successful
		  $message = 'User added';          // Tell user
			$show_form = false;
		} else {                            // Otherwise
		  $message = 'Unable to add user' . $user_added; // Show error - where is this coming from
		}
  } 
		
} ?>

<body>
    <?php require_once('login-menu.php'); ?>
<div class='error indent'><?= $message; ?></div>
<?php if ($show_form == true) { ?>
  <form id="form1" class="indent" method="post" action="register-password.php">
    <label for="forename">First name
        <input type="text" id="forename" name="forename" placeholder="First name" value="<?=$forename ?>" /> 
        <div class='error'><?= $valid["forename"]; ?></div>
    </label>
    <label for="surname">Last name
        <input type="text" id="surname"  name="surname" placeholder="Last name" value="<?=$surname ?>" />
         <div class='error'><?= $valid["surname"]; ?></div>
    </label>
    <label for="email">Email address
        <input type="email" id="email" name="email" placeholder="Enter email" value="<?=$email ?>" />
        <div class='error'><?= $valid["email"]; ?></div>
    </label>
    <label for="password">Password
    <input type="password"  name="password" placeholder="Password" autocomplete="new-password" />
        <div class='error'><?= $valid["password"]; ?></div>
    </label>
    <label for="confirm">Confirm Password
        <input type="password"  name="confirm" placeholder="Confirm Password" autocomplete="new-password" />
        <div class='error'><?= $valid["confirm"]; ?></div>
    </label>
    <button type="submit" class="btn btn-default">Register</button>
  </form>
<?php } ?>
</body>
</html>
 