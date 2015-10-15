<?php 
require_once('../includes/db_config.php');
$redirect = '../admin/index.php';
$valid = array('email' => '', 'password' =>'', 'result'=>'');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
$valid =validate_login_form($dbHost,$valid);
  if (strlen(implode($valid)) < 1) {
    $user = get_user($dbHost, $_POST['email'], $_POST['password']);
    if ($user->CorrectDetails == 1) {
      create_session($user);
      header('Location: '.$redirect);
    }
    $valid['result'] = '<div class="warning">Login failed</div>';
  }
}

function validate_login_form($connection,$valid) {
  if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ) {
    $valid['email'] = "Please enter a valid email";
  }
  if (!filter_input(INPUT_POST, 'password') ) {
    $valid['password'] = "Please enter a password";
  }
  return $valid;
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

<form method="post" action="../login/login.php">
  <h1>Please login:</h1>
  <?=$valid['result']; ?>
  <label for="emailAddress">Email</label>
  <input type="email" name="email" placeholder="Email"><?=$valid['email']; ?><br>
  <label for="password">Password</label>
  <input type="password" name="password" placeholder="Password"><?=$valid['password']; ?><br>
  <button type="submit">Login</button>    
</form>