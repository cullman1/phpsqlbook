<?php
require_once('../includes/database_connection.php');
require_once('../classes/class_lib.php');
$show_form = true;
$alert = array('status'  => '', 'message' => '');
$error = array('forename' => '', 'surname' =>'', 'email' => '', 
               'password' => '', 'confirm' => '');
$forename  = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname   = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email     = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password  = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 

function get_user_by_email($email) {
  $query = 'SELECT * from user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email', $email);
  $statement->execute();
  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');            
    $user = $statement->fetch();
  }
  return ($user ? $user : false);
}

function add_user_textpassword($forename, $surname, $password, $email) {     
  $query = 'INSERT INTO user (forename, surname, email, password) 
    VALUES ( :forename, :surname, :email, :password)';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':forename', $forename );
  $statement->bindParam(':surname', $surname );
  $statement->bindParam(':email',$email);
  $statement->bindParam(':password',$password);
  $result = $statement->execute();
  return (($result == true) ? true : $statement->errorCode());   
 }

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $Validate = new Validate();   // Create validation object
  $error['forename'] = $Validate->isFirstName($forename);
  $error['surname']  = $Validate->isLastName($surname);
  $error['email']    = $Validate->isEmail($email);
  $error['password'] = $Validate->isStrongPassword($password);
  $error['confirm']  = $Validate->isConfirmPassword($password, $confirm);
  $valid = implode($error);
  if (strlen($valid)>1)  {  // If the form is valid, then send the reset password link
    $alert = array('status' => 'danger', 'message' => 'Please check errors below:');
  } else {
    $user = get_user_by_email($email);
     $alert = array('status' => 'danger', 'message' => 'User email already exists!');
    if (!$user) {   
      $user_added = add_user_textpassword($forename,  $surname,  $password, $email);	
      if ($user_added) {      
        $alert = array('status' => 'success', 'message' => 'User added.');   
        $show_form = false;
       } else {                           
        $alert = array('status' => 'danger',  'message' => 'Unable to add user.');
       }
    } 
  }
} ?>

<body>
 <div class="<?= $alert['status'] ?>">
      <?= $alert['message'] ?></div>
 <?php if ($show_form) { ?>
 <form method="post" action="register.php">
   <label>First name <input type="text" name="forename" 
          placeholder="Forename" 
          value="<?=$forename ?>" /></label>
   <span class="error"><?= $error['forename'] ?></span>
   <label>Last name <input type="text" name="surname" 
          placeholder="Surname" 
          value="<?=$surname ?>" /></label>
   <span class="error"><?= $error['surname'] ?></span>
   <label>Email address <input type="email" name="email" 
          placeholder="Email" 
          value="<?=$email ?>" /></label>
   <span class="error"><?= $error['email'] ?></span>
   <label>Password <input type="password"
          name="password" 
          placeholder="Password" /></label>
   <span class="error"><?= $error['password'] ?></span>
   <label>Confirm Password <input type="password"  
          name="confirm" 
          placeholder="Confirm Password"  /></label>
   <span class="error"><?= $error['confirm'] ?></span>
   <button type="submit">Register</button>
 </form>
 <?php } ?>
</body>