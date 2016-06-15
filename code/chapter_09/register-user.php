<?php  require_once('includes/database_connection.php'); 
include 'login-menu.php';
$form_error = array('email' => '', 'password' =>'', 'forename'=>'', 'surname'=>'', 'confirm'=>'','result'=>'');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$forename = filter_input(INPUT_POST, 'forename');
$surname = filter_input(INPUT_POST, 'surname');
$password = filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/")));  
$confirm = filter_input(INPUT_POST, 'confirm', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/")));  

function get_existing_user($email) {
   $query = "SELECT * from user WHERE email = :email";
   $statement = $GLOBALS['connection']->prepare($query);
   $statement->bindParam(":email",$email);
   $statement->execute();
   $user = $statement->setFetchMode(PDO::FETCH_ASSOC);
   return ($user ? $user : false);
}

function insert_user($firstName, $surname, $password, $email) {     
  $query = "INSERT INTO user (forename, surname, password, email, role_id) VALUES ( :forename, :surname, :password, :email, 2)";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(":forename", $firstName );
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

 function validate_form($form_error, $forename, $surname, $password, $confirm, $email) {
   if (!$password) {
        $form_error["password"] = "<div class='success'>Password doesn't meet requirements</div>";
    } 
    if (!$forename) {
        $form_error["forename"] = "<div class='success'>Need to enter forename</div>";
    }  
    if (!$surname) {
        $form_error["surname"] = "<div class='success'>Need to enter surname</div>";    
    } 
    if (!$email) {
        $form_error["email"] = "<div class='success'>Email not valid</div>";
    }  
    if ($password != $confirm) {
        $form_error["confirm"] = "<div class='success'>Passwords don't match!</div>";
    } 
    return $form_error;
  } 

  function register($forename, $surname,$password,$email, $form_error) {
            $user = get_existing_user($email);
            if ($user) {
                $form_error["result"] = insert_user($forename, $surname,$password,$email);
                echo  $form_error["result"];
            } else {
                $form_error["result"] = "<span class='red'>A user with that email address has already been registered!</span>";
            }
            return $form_error;
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form_error = validate_form($form_error, $forename, $surname, $password, $confirm, $email);
  } 
  $test_error = array_filter($form_error);
  if (($email) && (empty($test_error))) {
    $form_error = register($forename, $surname,$password,$email, $form_error);
  } else { ?>
   <form id="form1" class="indent" style="width:450px;" method="post" action="register-user.php">
    <div class="tk-proxima-nova" style="padding-left:10px">
     <?= $form_error["result"]; ?><br/>    
           <label for="forename">First name</label>
           <input type="text" id="forename" name="forename" placeholder="First name"><?= $form_error["forename"]; ?><br/><br/>
           <label for="surname">Last name</label>
           <input type="text" id="surname"  name="surname" placeholder="Last name"><?= $form_error["surname"]; ?><br/><br/>
            <label for="email">Email address</label>
           <input type="email" id="email" name="email" placeholder="Enter email"><?= $form_error["email"]; ?><br/><br/>
           <label for="password">Password</label>
           <input type="password"  name="password" placeholder="Password"><?= $form_error["password"]; ?><br/><br/>  
           <label for="confirm">Confirm Password</label>
           <input type="confirm"  name="confirm" placeholder="Confirm Password"><?= $form_error["confirm"]; ?><br/><br/>  
           <button type="submit" class="btn btn-default">Register</button>
    </div>
  </form>
<?php }  ?>
