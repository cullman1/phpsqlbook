<?php  
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database_connection.php'); 
include ('login-menu.php');
$show_form = true;
$message = '';
$valid = array('forename' => '', 'surname' =>'', 'email' => '', 'password' => '', 'confirm'=>'' );
$forename = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname  = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm  = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 

function validate_form($forename,$surname,$email,$password,$confirm, $valid){
  $valid['forename'] = ((!filter_var($forename, FILTER_DEFAULT))   ? 'Enter forename' : '');
  $valid['surname'] = "This is being set";
  //$valid['surname']  = (!filter_var($surname,  FILTER_DEFAULT)) ? 'Enter surname'  : '';
  $valid['email']    = ((!filter_var($email,    FILTER_VALIDATE_EMAIL))   ? 'Enter email'    : '');
  $valid['password'] = ((!filter_var($password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/"))) ? 'Enter password' : ''));
  if ($valid['password'] == '') {
	  $valid['confirm'] = ($password == $confirm ? 'Passwords do not match' : '');
	}
  if ($valid['email'] == '') {
    $user_exists = get_user_by_email($email);
  	if ($user_exists == false) {
      $valid['email'] == 'User already exists';
  	}
	}
      echo "in function".$valid["surname"] ."<br/>";
      $valid2 = $valid;
  $validation_passed=      array_filter($valid2);
  return $validation_passed;
}

function get_user_by_email($email) {
   $query = "SELECT * from user WHERE email = :email";
   $statement = $GLOBALS['connection']->prepare($query);
   $statement->bindParam(":email",$email);
   $statement->execute();
   $user = $statement->setFetchMode(PDO::FETCH_OBJ);
   return ($user ? $user : false);
}
 
function add_user($forename, $surname, $password, $email) {     
  $query = "INSERT INTO user (forename, surname, email, password, role_id) VALUES ( :forename, :surname, :email, :password, 2)";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(":forename", $forename );
  $statement->bindParam(":surname", $surname );
  $statement->bindParam(":email",$email);
  $statement->bindParam(":password",$password);
  $result = $statement->execute();
  if( $result == true ) {     
      return true;
  } else {
      return $statement->errorCode();
  }	   
 } 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $valid2 = validate_form($forename,$surname,$email,$password,$confirm, $valid);
  echo "out of function".$valid2["surname"] ."<br/>";
 /* if ($validation_passed == true) {
	  $user_added = add_user($forename, $surname, $password, $email);						// Try to add user
    if ($user_added == true) {          // If successful
		  $message = 'User added';          // Tell user
			$show_form = false;
		} else {                            // Otherwise
		  $message = 'Unable to add user' . $user_added; // Show error - where is this coming from
		}
  } else {
		$message = 'Please check errors below and resubmit form';
	} */
} ?>

<body>


<?= $message; ?>
<?php if ($show_form == true) { ?>
  <form id="form1" class="indent" method="post" action="register-user3.php">
    <label for="forename">First name</label>
    <input type="text" id="forename" name="forename" placeholder="First name" value="<?=$forename ?>" <?= $valid["forename"]; ?>
    <label for="surname">Last name</label>
    <input type="text" id="surname"  name="surname" placeholder="Last name" value="<?=$surname ?>"><?= $valid["surname"]; ?>
    <label for="email">Email address</label>
    <input type="email" id="email" name="email" placeholder="Enter email" value="<?=$email ?>"><?= $valid["email"]; ?>
    <label for="password">Password</label>
    <input type="password"  name="password" placeholder="Password" autocomplete="new-password"><?= $valid["password"]; ?><br/><br/>  
    <label for="confirm">Confirm Password</label>
    <input type="password"  name="confirm" placeholder="Confirm Password" autocomplete="new-password"><?= $valid["confirm"]; ?><br/><br/>  
    <button type="submit" class="btn btn-default">Register</button>
  </form>
<?php } ?>
 