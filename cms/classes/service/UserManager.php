<?php

class UserManager
{

  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function getUserById($id)
  {
    $pdo = $this->pdo;
    $sql = 'SELECT user.id, user.forename, user.surname, user.joined, user.image FROM user WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
    $user = $statement->fetch();
    if (!$user) {
      return null;
    }
    return $user;
  }

  function get_user_by_email_password($email, $password) {
   $pdo = $this->pdo;
  $query = 'SELECT * FROM user WHERE email = :email';
  $statement = $pdo->prepare($query);
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
  $_SESSION['user_id'] = $user->id;
}

}