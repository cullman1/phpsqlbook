<?php
require_once('../includes/database_connection.php');
$alert    = array('status'  => '', 'message' => '');
$email    = (isset($_POST['email']) ? $_POST['email'] : '' ); 
$password = (isset($_POST['password']) ? $_POST['password'] : '' ); 
$valid    = array('email' => '', 'password' =>'');

function validate_login ($email,$password, $valid) {
  $valid['email']    = ((filter_var($email,  FILTER_DEFAULT)) ? ''   : 'Add email' );
  $valid['password'] = ((filter_var($password, FILTER_DEFAULT)) ? '' : 'Add password' );
  return $valid;
}

function get_user_by_email_password($email, $password) {
  $query = 'SELECT * FROM user WHERE email =:email AND password= :password';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email',$email);
  $statement->bindParam(':password',$password);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  return ($user ? $user : false);
}

function get_user_by_email_passwordhash($email, $password) {
  $query = 'SELECT * FROM user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email',$email);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  if (!$user) { return false; }
  return (password_verify($password, $user->password) ? $user : false);
}

function create_session($user) {
  session_start();
  $_SESSION['forename'] = $user->forename;
  $_SESSION['image'] =($user->image ? $user->image : 'default.jpg');
  $_SESSION['tasks'] = get_tasks_by_role_id($user->role_id);
}

function get_tasks_by_role_id($role_id) {
  $query = 'SELECT task.id, task.name FROM task 
            JOIN tasks_in_role ON task.id = tasks_in_role.task_id 
            WHERE tasks_in_role.role_id = :roleid';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':roleid', $role_id);
  $statement->execute();
  $task = $statement->fetchAll(PDO::FETCH_ASSOC);
  return ($task ? $task : false);
}


if($_SERVER['REQUEST_METHOD'] == 'POST') {
 $valid = validate_login($email, $password, $valid);
 $validation_failed = array_filter($valid);
 if ($validation_failed == true) {
   $alert = array('status'  => 'danger', 'message' => 'Please check errors and resubmit');
 } else {
   $user=get_user_by_email_passwordhash($email, $password);
   if ($user) {
      create_session($user);
      header('Location:article-list-role.php'); 
    } else {
       $alert = array('status'  => 'danger', 
       'message' => 'Login failed');
    }
  }
} ?>

<form method='post' action='login-role.php'>
 <span class="<?= $alert['status'] ?>">
  <?= $alert['message'] ?>
 </span><br>
 <label>Email
  <input type='text' name='email' placeholder='Email'/>  
  <span class="<?= $alert['status'] ?>">   
   <?=$valid['email']; ?>
  </span>
 </label><br>
 <label>Password <input type='password' name='password'  
   placeholder='Password' /> 
  <span class="<?= $alert['status'] ?>">
    <?= $valid['password']; ?>
  </span>
 </label><br>
 <button type='submit'>Login</button>    
</form>