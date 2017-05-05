<?php
function get_user_by_email_password($email, $password) {
  $query = 'SELECT * FROM user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
    $user = $statement->fetch();
  }
  if (!$user) { 
    return FALSE; 
  }
  return (password_verify($password, $user->password) ? $user : FALSE);
}

function create_user_session($user) {
  $_SESSION['name']    = $user->forename;
  $_SESSION['image']   = ($user->image ? $user->image : 'default.jpg');
  $_SESSION['user_id'] = $user->id;
}

function get_user_by_email($email) {
  $sql = 'SELECT * from user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($sql);
  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');            
    $user = $statement->fetch();
  }
  return ($user ? $user : FALSE);
}
?>