<?php  
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database_connection.php'); 
include ('login-menu.php');
$message = array('forename'=>'', 'surname'=>'', 'email' => '', 'password' =>'',  'confirm'=>'','result'=>'');
$forename = (filter_input(INPUT_POST, 'forename') ? $_POST['forename']   : '' );
$surname = (filter_input(INPUT_POST, 'surname') ? $_POST['surname']   : '' );
$email = (filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)? $_POST['email']   : '' );
$password = filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/")));  
$confirm = filter_input(INPUT_POST, 'confirm', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/")));  

function get_user_by_email($email) {
   $query = "SELECT * from user WHERE email = :email";
   $statement = $GLOBALS['connection']->prepare($query);
   $statement->bindParam(":email",$email);
   $statement->execute();
   $user = $statement->setFetchMode(PDO::FETCH_ASSOC);
   return ($user ? $user : false);
}

function add_user($forename, $surname, $password, $email) {     
  $query = "INSERT INTO user (forename, surname, password, email, role_id) VALUES ( :forename, :surname, :password, :email, 2)";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(":forename", $forename );
  $statement->bindParam(":surname", $surname );
  $statement->bindParam(":password",$password);
  $statement->bindParam(":email",$email);
  $statement->execute();
  if( $statement->errorCode() != 00000 ) {     
      return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
      return '<div class="success">User successfully registered</div>';
  }	   
 } 

 function validate_form($forename, $surname, $password, $email, $confirm,  $form_error, ) {
   if (!$password) {
        $message["password"] = "<div class='success'>Password doesn't meet requirements</div>";
    } 
    if (!$forename) {
        $message["forename"] = "<div class='success'>Need to enter forename</div>";
    }  
    if (!$surname) {
        $message["surname"] = "<div class='success'>Need to enter surname</div>";    
    } 
    if (!$email) {
        $message["email"] = "<div class='success'>Email not valid</div>";
    }  
    if ($password != $confirm) {
        $message["confirm"] = "<div class='success'>Passwords don't match!</div>";
    } 
    return $message;
  } 

  function register($forename, $surname,$email, $password, $message) {
            $user = get_user_by_email($email);
            if ($user) {
                $message["result"] = insert_user($forename, $surname,$email, $password);
                echo  $message["result"];
            } else {
                $message["result"] = "<span class='red'>A user with that email address has already been registered!</span>";
            }
            return $message;
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = validate_form($forename, $surname, $password, $confirm, $email, $message);
  } 
  $form_contains_error = array_filter($message);
  if (($email) && (empty($form_contains_error))) {
    $message = register($forename, $surname,$password,$email, $message);
  } else {

 ?>
   <form id="form1" class="indent" style="width:450px;" method="post" action="register-user2.php" autocomplete="off">
    <div class="tk-proxima-nova" style="padding-left:10px">
     <?= $message["result"]; ?><br/>    
           <label for="forename">First name</label>
           <input type="text" id="forename" name="forename" placeholder="Enter First name" value="<?= $forename; ?>"><?= $message["forename"]; ?><br/><br/>
           <label for="surname">Last name</label>
           <input type="text" id="surname"  name="surname" placeholder="Enter Last name" value="<?= $surname; ?>"><?= $message["surname"]; ?><br/><br/>
            <label for="email">Email address</label>
           <input type="email" id="email" name="email" placeholder="Enter Email" value="<?= $email; ?>"><?= $message["email"]; ?><br/><br/>
           <label for="password">Password</label>
           <input type="password"  name="password" placeholder="Enter Password" autocomplete="new-password"><?= $message["password"]; ?><br/><br/>  
           <label for="confirm">Confirm Password</label>
           <input type="password"  name="confirm" placeholder="Confirm Password" autocomplete="new-password"><?= $message["confirm"]; ?><br/><br/>  
           <button type="submit" class="btn btn-default">Register</button>
    </div>
  </form>
<?php }  ?>
