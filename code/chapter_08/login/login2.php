<?php 
require_once('../includes/db_config.php');
$redirect = '../links.php';
$form_error = array('email' => '', 'password' =>'', 'result'=>'');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email      = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);  
  $password   = filter_input(INPUT_POST, 'password');      
  $form_error =validate_login_form($form_error, $email,$password);
  if (strlen(implode($form_error)) < 1) {
    $user = get_user($dbHost,$email,$password);
    if ($user->CorrectDetails == 1) {
      create_session($user);
      header('Location: '.$redirect);
    }
    $form_error['result'] = '<div class="warning">Login failed</div>';
  }
}

function validate_login_form($form_error, $email,$password) {
  if (!$email)  {
    $form_error['email'] = "Please enter a valid email";
  }
  if (!$password) {
    $form_error['password'] = "Please enter a password";
  }
  return $form_error;
}

function get_user($connection, $email, $password) {
  $query = "SELECT COUNT(*) as CorrectDetails, user_id, full_name, email 
            FROM user WHERE email =:email AND password= :password";
  $statement = $connection->prepare($query);
  $statement->bindParam(':email',$email);
  $statement->bindParam(':password',$password);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  return $user;
}

function create_session($user) {
  session_start();
  $_SESSION['authenticated'] = $user->user_id;
  $_SESSION['username'] = $user->full_name;
  $_SESSION['email'] = $user->email;
}
?>

<form method="post" action="../login/login2.php">
  <h1>Please login:</h1>
  <?=$form_error['result']; ?>
  <label for="emailAddress">Email</label>
  <input type="email" name="email" placeholder="Email"><?=$form_error['email']; ?><br>
  <label for="password">Password</label>
  <input type="password" name="password" placeholder="Password"><?=$form_error['password']; ?><br>
  <button type="submit">Login</button>    
</form>