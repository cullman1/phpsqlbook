<?php
require_once('../includes/database_connection.php');
$show_form = true;
$alert = array('status'  => '', 'message' => '');
$valid = array('forename' => '', 'surname' =>'', 'email' => '', 
               'password' => '', 'confirm' => '');
$forename  = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname   = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email     = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password  = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' );  

function validate_form($forename, $surname, $email, $password, $confirm, $valid) {
  //Forename, surname and email validation check
  $valid['forename'] = (filter_var($forename, FILTER_DEFAULT)) ? ''  : 'Enter forename';
  $valid['surname']  = (filter_var($surname,  FILTER_DEFAULT)) ? ''  : 'Enter surname';
  $valid['email']    = (filter_var($email, FILTER_VALIDATE_EMAIL)) ? '' : 'Enter email';
  //Password and Confirm validation check 
  $valid['password'] = (filter_var($password, FILTER_VALIDATE_REGEXP, array('options'=> 
  array('regexp'=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/"))) ? '': 'Password not valid' );
  $valid['confirm']  = (filter_var($confirm, FILTER_DEFAULT)) ? '' : 'Confirm password';
  //Compare password and confirm controls
  if ($valid['password'] == '') {
    $valid['confirm'] = ($password == $confirm ? '' : 'Passwords do not match' );
  }
  //If email is valid, check if it is already in database
  if ($valid['email'] == '') {
    $user_exists = get_user_by_email($email);
    if ($user_exists) {
      $valid['email'] = 'User already exists';
    }
  }
  return $valid;
}

function get_user_by_email($email) {} // See Ch 5 pXXX

function add_user_textpassword($forename, $surname, 
                  $password, $email) {     
  $query = 'INSERT INTO user
    (forename, surname, email, password) 
    VALUES ( :forename, :surname, :email, :password)';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':forename', $forename );
  $statement->bindParam(':surname', $surname );
  $statement->bindParam(':email',$email);
  $statement->bindParam(':password',$password);
  $result = $statement->execute();
  return (($result == true) ? true : 
           $statement->errorCode());   
 }




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $valid = validate_form($forename, $surname, $email,  
  $password, $confirm, $valid);
  $validation_failed = array_filter($valid);
  if ($validation_failed == true) {
    $alert = array('status' => 'danger', 
    'message' => 'Please check errors below:');
  } else {
    $user_added = add_user_textpassword($forename, 
      $surname,  $password, $email);	
    if ($user_added) {      
      $alert = array('status' => 'success', 
      'message' => 'User added.');   
      $show_form = false;
     } else {                           
      $alert = array('status' => 'danger', 
    'message' => 'Unable to add user.');
    }
  } 
}
?><body>
 <div class="<?= $alert['status'] ?>">
      <?= $alert['message'] ?></div>
 <?php if ($show_form) { ?>
 <form method="post" action="register.php">
   <label>First name <input type="text" name="forename" 
          placeholder="Forename" 
          value="<?=$forename ?>" /></label>
   <span class="error"><?= $valid['forename'] ?></span>
   <label>Last name <input type="text" name="surname" 
          placeholder="Surname" 
          value="<?=$surname ?>" /></label>
   <span class="error"><?= $valid['surname'] ?></span>
   <label>Email address <input type="email" name="email" 
          placeholder="Email" 
          value="<?=$email ?>" /></label>
   <span class="error"><?= $valid['email'] ?></span>
   <label>Password <input type="password"
          name="password" 
          placeholder="Password" /></label>
   <span class="error"><?= $valid['password'] ?></span>
   <label>Confirm Password <input type="password"  
          name="confirm" 
          placeholder="Confirm Password"  /></label>
   <span class="error"><?= $valid['confirm'] ?></span>
   <button type="submit">Register</button>
 </form>
 <?php } ?>
</body>