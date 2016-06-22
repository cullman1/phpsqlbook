<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database_connection.php'); 

$message = '';
$email =    (isset($_POST['email']) ? $_POST['email'] : '' ); 
$password = (isset($_POST['password']) ? $_POST['password'] : '' ); 
$valid = array('email' => '', 'password' =>'');

function validate_login_form($email,$password, $valid) {
  $valid['email'] = (filter_var($email,  FILTER_DEFAULT))? ''   : 'Enter email' ;
  $valid['password'] = (filter_var($password,  FILTER_DEFAULT))? ''   : 'Enter password' ;
  return $valid;
}

	function get_user($email, $password) {
      					$query = "SELECT user.id, forename, surname, email, image, role_id FROM user 
			          JOIN password on user.id = password.id
	              WHERE email =:email AND hash= :token";
      					$statement = $GLOBALS['connection']->prepare($query);
      					$statement->bindParam(':email',$email);
								$hash = hash_password($password);

      					$statement->bindParam(':token', $hash);
      					$statement->execute();
      					$user = $statement->fetch(PDO::FETCH_OBJ);
      					return ($user ? $user : false);
    					}

function create_session($user) {
    session_start();
   $_SESSION['forename'] = $user->forename;
   $_SESSION['image'] =($user->image ? $user->image : "default.jpg");
   $_SESSION['tasks'] = get_tasks_by_role($user->role_id);
   //print_r ($_SESSION['tasks']);
}

function get_tasks_by_role($roleid) {
    $query = "SELECT task.id, task.name FROM task 
			          JOIN tasks_in_role on task.id = tasks_in_role.task_id
	              WHERE tasks_in_role.role_id = :roleid";
    $statement = $GLOBALS['connection']->prepare($query);
    $statement->bindParam(':roleid',$roleid);
    $statement->execute();
    $task = $statement->fetch(PDO::FETCH_ASSOC);
    return $task;
}


function hash_password($password) {
									$salt = "abD!y1" . $password . "d!@gg3";
									$hash = sha1($salt); 
									return $hash;
							}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
 $valid = validate_login_form($email, $password, $valid);
 $validation_failed = array_filter($valid);
  if ($validation_failed == true) {
    $message = 'Please check errors below and resubmit form';
  } else {
   $user = get_user($email, $password);
  
    if ($user) {
      create_session($user);
      header('Location: login-home.php');
    } else {
    $message = 'Login failed';
    }
  }
}
?>
<head>
<script src="https://use.typekit.net/goi2qmp.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<title>Login</title>
</head>
<? require_once('login-menu.php'); ?>
<div class="tk-proxima-nova" style="padding-left:10px;">
<form method="post" action="login-role.php">
  <div class="error"><?=$message; ?></div>
  <label for="email">Email
    <input type="text" name="email" placeholder="Email" />  
    <div class='error'><?=$valid['email']; ?></div>
  </label>
  <label for="password">Password
    <input type="password" name="password" placeholder="Password" /> 
    <div class='error'><?= $valid['password']; ?></div></label>
  <button type="submit">Login</button>    
</form>
</div>