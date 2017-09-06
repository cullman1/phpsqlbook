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

function create($forename, $surname, $email, $password) {
    $pdo = $this->pdo;                             // Connection
    $sql = 'INSERT INTO user (forename, surname, email, password) 
                   VALUES (:forename, :surname, :email, :password)';
    $statement = $pdo->prepare($sql);                          // Prepare
    $statement->bindValue(':forename', $forename);              // Bind value
    $statement->bindValue(':surname',  $surname);               // Bind value
    $statement->bindValue(':email',    $email);                 // Bind value
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $statement->bindValue(':password', $hash);                        // Bind value
    try {
        $statement->execute();                                          // Try to execute
        $result = TRUE;                                                 // Say it worked
    }
    catch (PDOException $error) {                                   // Otherwise
        $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];   // Error
    }
    return $result;                                                    
}

function get_user_by_email($email) {
    $pdo = $this->pdo;
    $sql = 'SELECT * from user WHERE email = :email';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':email', $email);
    if ($statement->execute() ) {
      $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');            
      $user = $statement->fetch();
    }
    return ($user ? $user : FALSE);
  }


}