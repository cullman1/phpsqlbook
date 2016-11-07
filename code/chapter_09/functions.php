<?php

function get_user_by_email_password($email, $password) {
  $query = 'SELECT user.* FROM user WHERE email = :email AND password = :password';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email', $email);
  $statement->bindParam(':password', $password);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  return ($user ? $user : false);
}

function create_user_session($user) {
  $_SESSION['forename'] = $user->{'user.forename'};
  $_SESSION['image']  = ($user->{'user.image'} ? $user->{'user.image'} : 'default.jpg');
  $_SESSION['loggedin'] = $user->{'user.joined'};
}

function logout_user() {
 $_SESSION = array();
 setcookie(session_name(),'', time()-3600, '/');
}
?>