<?php
class UserManager {
  
  private $pdo;
  
  public function __construct($pdo) {
    $this->pdo = $pdo;
  }
  
  public function getUserById($user_id) {
    $pdo = $this->pdo;
    $sql = 'SELECT user.user_id, user.forename, user.surname, user.joined, user.email, user.picture
            FROM user 
            WHERE user_id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
    $user = $statement->fetch();
    if (!$user) {
      return null;
    }
    return $user;
  }

    public function getUserByEmail($email) {
    $pdo = $this->pdo;
    $sql = 'SELECT user.user_id, user.forename, user.surname, user.email, user.joined, user.role, user.seo_name 
            FROM user WHERE email = :email';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':email', $email);
    if ($statement->execute() ) {
      $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
      $user = $statement->fetch();
    }
    return ($user ? $user : FALSE);
  }

  public function getAllUsers() {
    $pdo = $this->pdo;
    $sql = 'SELECT user.user_id, user.forename, user.surname, user.email FROM user';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
    $user_list = $statement->fetchAll();
    if (!$user_list) {
      return null;
    }
    return $user_list;
  }

   public function isLoggedIn() {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    return ( isset($_SESSION['user_id']) ? TRUE : FALSE);
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
    $_SESSION['name']     = CMS::cleanLink($user->forename);

    $_SESSION['user_id']  = $user->user_id;
    $_SESSION['role']     = $user->role;
  }
   public function redirectNonAdmin() {
    if (!isset($_SESSION['role'])) {
      CMS::redirect('users/login.php');
    } else {
      if ($_SESSION['role'] == 2) {
          CMS::redirect('page-not-found.php');
      }
    }
  }

    public function createSuperAdmin($user) {
    $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
  
    $pdo  = $this->pdo;
    $sql  = 'INSERT INTO user (forename,  surname,  email,  password,  joined,   role) 
		                  VALUES (:forename, :surname, :email, :password, :joined, :role)'; // SQL
    $statement = $pdo->prepare($sql);                              // Prepare
    $statement->bindValue(':forename',      $user->forename);      // Bind value
    $statement->bindValue(':surname',       $user->surname);       // Bind value
    $statement->bindValue(':email',         $user->email);         // Bind value
    $statement->bindValue(':password',      $hash);                // Bind value
    $statement->bindValue(':joined',        date('Y-m-d H:i:s')); // Bind value
       $statement->bindValue(':role',  $user->role     ); // Bind value

    try {
      $statement->execute();
      $user->user_id = $pdo->lastInsertId();                                // Add id to object
      $result = TRUE;
    } catch (PDOException $error) {                                    // Otherwise
      $result = $error->getMessage() . '<br>File: ' . $error->getFile() . '<br>Line: '  . $error->getLine();    // Error - use the methods not array
    }
    return $result;                                                    // Say succeeded
  }

  public function checkSuperAdmin() {
    $pdo = $this->pdo;
    $sql = 'SELECT user.user_id FROM user where role = 0';
    $statement = $pdo->prepare($sql);
    $statement->execute();  // Execute
    return $statement->fetchColumn();                   // Return count from function
  }
}