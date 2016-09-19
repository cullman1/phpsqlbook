<?php
require_once('../includes/database_connection.php');
require_once('../includes/functions.php');
$show_form = true;
$alert = array('status'  => '', 'message' => '');
$valid = array('forename' => '', 'surname' =>'', 'email' => '', 'password' => '',
 'confirm' => '');
$forename  = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname   = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email     = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password  = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 

function validate_form($forename, $surname, $email, $password, $confirm, $valid) {
  $valid['forename'] = (filter_var($forename, FILTER_DEFAULT))? ''  : 'Enter forename' ;
  $valid['surname'] = (filter_var($surname,  FILTER_DEFAULT)) ? ''  : 'Enter surname' ;
  $valid['email'] = (filter_var($email, FILTER_VALIDATE_EMAIL))   ? '' : 'Enter email' ;
  $valid['password'] = (filter_var($password, FILTER_VALIDATE_REGEXP, array("options"=> 
  array("regexp"=>"/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/"))) ? '': 'Password not valid' );
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $valid = validate_form($forename, $surname, $email,  
  $password, $confirm, $valid);
  $validation_failed = array_filter($valid);
  if ($validation_failed == true) {
    $alert['message'] = 'Please check errors below';
  } else {
    //Try to add user
    $user_added = add_user($forename, $surname, 
    $password, $email);
    if ($user_added) {      
      $alert['message'] = 'User added';        
      $show_form = false;
     } else {                           
      $alert['message'] = 'Unable to add user'; 
    }
  } 
}
?>

<body>
 <div class='<?= $alert['status'] ?>'><?= $alert['message'] ?></div>
 <?php if ($show_form) { ?>
 <form method='post' action='register-cms.php'>
   <label for='forename'>First name
     <input type='text' name='forename' 
     placeholder="Forename" value="<?=$forename ?>" /> 
     <span class='<?= $alert['status'] ?>'><?= $valid['forename']; ?></span>
   </label><br>
   <label for='surname'>Last name
     <input type='text' name='surname' placeholder='Surname' value='<?=$surname ?>' />
     <span class='<?= $alert['status'] ?>'><?= $valid['surname']; ?></span>
   </label><br>
   <label for='email'>Email address
     <input type='email' name='email' placeholder='Email' value="<?=$email ?>" />
     <span class='<?= $alert['status'] ?>'><?= $valid['email']; ?></span>
   </label><br>
   <label for='password'>Password
     <input type='password' name='password' placeholder='Password'  />
     <span class='<?= $alert['status'] ?>'><?= $valid['password']; ?></span>
   </label><br>
   <label for='confirm'>Confirm Password
     <input type='password'  name='confirm' placeholder='Confirm Password'  />
     <span class='<?= $alert['status'] ?>'><?= $valid['confirm']; ?></span>
   </label><br>
   <button type='submit' class='btn btn-default'>Register</button>
 </form>
 <?php } ?>
</body>