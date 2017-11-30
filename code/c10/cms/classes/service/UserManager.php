<?php
class UserManager {
  
  private $pdo;
  
  public function __construct($pdo) {
    $this->pdo = $pdo;
  }
  
  public function getUserById($id) {
    $pdo = $this->pdo;
    $sql = 'SELECT user.id, user.forename, user.surname, user.joined, user.profile_image 
            FROM user WHERE id = :id';
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

   public function isLoggedIn() {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    return ( isset($_SESSION['user_id']) ? TRUE : FALSE);
  }

   public function redirectNonAdmin() {
    if (!isset($_SESSION['role'])) {
      Utilities::errorPage('users/login.php');
    } else {
      if ($_SESSION['role'] != 2) {
        Utilities::errorPage('page-not-found.php');
      }
    }
  }
   public function getUserByEmailPassword($email, $password) {
    $pdo = $this->pdo;
    $query = 'SELECT * FROM user WHERE email = :email';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':email', $email);
    if ($statement->execute() ) {
      $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
      $user = $statement->fetch();
    }
    if (!$user) {
      return FALSE;
    }
    return (password_verify($password, $user->getPassword()) ? $user : FALSE);
  }

   public function createUserSession($user) {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION['name']     = htmlspecialchars($user->forename);
    $_SESSION['seo_name'] = $user->seo_name;
    $_SESSION['user_id']  = $user->id;
    $_SESSION['role']     = $user->role;
  }

    public function getAllUsers() {
    $pdo = $this->pdo;
    $sql = 'SELECT user.id, user.forename, user.surname, user.email, user.joined FROM user';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
    $user = $statement->fetchAll();
    if (!$user) {
      return null;
    }
    return $user;
  }
}

