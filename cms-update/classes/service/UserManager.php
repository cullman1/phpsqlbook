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
    $sql = 'SELECT user.user_id, user.forename, user.surname, user.email, user.joined, user.role, user.seo_name FROM user WHERE user_id = :id';
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

  public function getUserBySeoName($name) {
    $pdo = $this->pdo;
    $sql = 'SELECT * FROM user WHERE seo_name = :seo_name';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':seo_name', $name);
    if ($statement->execute() ) {
      $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
      $user = $statement->fetch();
    }
    return ($user ? $user : FALSE);
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

  public function isUserAuthorOfArticle($user_id, $article_id) {
    $pdo = $this->pdo;
    $query = 'SELECT count(*) FROM article WHERE user_id = :article_id AND user_id = :user_id';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':article_id', $article_id);
    $statement->execute();
    $count = $statement->fetchColumn();
    if ($count>0) {
      return TRUE;
    }
    return FALSE;
  }

  public function create($user) {
    $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
    $seo_name = Utilities::createSlug($user->getFullName());
    $pdo  = $this->pdo;
    $sql  = 'INSERT INTO user (forename,  surname,  email,  password,  joined,  seo_name,  picture) 
		                  VALUES (:forename, :surname, :email, :password, :joined, :seo_name, :picture)'; // SQL
    $statement = $pdo->prepare($sql);                              // Prepare
    $statement->bindValue(':forename',      $user->forename);      // Bind value
    $statement->bindValue(':surname',       $user->surname);       // Bind value
    $statement->bindValue(':email',         Utilities::punyCodeDomain($user->email));         // Bind value
    $statement->bindValue(':password',      $hash);                // Bind value
    $statement->bindValue(':joined',        date('Y-m-d H:i:s')); // Bind value
    $statement->bindValue(':seo_name',      $seo_name);            // Bind value
    $statement->bindValue(':picture', $user->picture); // Bind value

    try {
      $statement->execute();
      $user->user_id = $pdo->lastInsertId();                                // Add id to object
      $result = TRUE;
    } catch (PDOException $error) {                                    // Otherwise
      $result = $error->getMessage() . '<br>File: ' . $error->getFile() . '<br>Line: '  . $error->getLine();    // Error - use the methods not array
    }
    return $result;                                                    // Say succeeded
  }

  public function update($user){
    $seo_name = Utilities::createSlug($user->getFullName());

    $pdo = $this->pdo;
    $sql = 'UPDATE user SET forename = :forename, surname = :surname, email = :email, password = :password, seo_name = :seo_name, picture = :picture WHERE user_id = :id';         //SQL
    $statement = $pdo->prepare($sql);                              // Prepare
    $statement->bindValue(':id', $user->user_id, PDO::PARAM_INT);       // Bind value
    $statement->bindValue(':forename',      $user->forename);      // Bind value
    $statement->bindValue(':surname',       $user->surname);       // Bind value
    $statement->bindValue(':email',         Utilities::punyCodeDomain($user->email));         // Bind value
    $statement->bindValue(':password',      $user->getPassword()); // Bind value
    $statement->bindValue(':seo_name',      $seo_name);            // Bind value
    $statement->bindValue(':picture', $user->picture); // Bind value
    try {
      $statement->execute();
      $result = TRUE;
    } catch (PDOException $error) {                                    // Otherwise
      $result = $error->getMessage() . '<br>File: ' . $error->getFile() . '<br>Line: '  . $error->getLine();    // Error - use the methods not array
    }
    return $result;                                                   // Say succeeded
  }

  public function adminupdate($user){
    $seo_name = Utilities::createSlug($user->getFullName());
    $pdo = $this->pdo;
    $sql = 'UPDATE user SET forename = :forename, surname = :surname, email = :email, seo_name = :seo_name, role = :role WHERE user_id = :id';         //SQL
    $statement = $pdo->prepare($sql);                                // Prepare
    $statement->bindValue(':id', $user->user_id, PDO::PARAM_INT);         // Bind value
    $statement->bindValue(':forename', $user->forename);             // Bind value
    $statement->bindValue(':surname',  $user->surname);              // Bind value
    $statement->bindValue(':email',    Utilities::punyCodeDomain($user->email));                // Bind value
    $statement->bindValue(':role',     $user->role, PDO::PARAM_INT); // Bind value
     $statement->bindValue(':seo_name',      $seo_name);            // Bind value
    try {
      $statement->execute();
      $result = TRUE;
    } catch (PDOException $error) {                                    // Otherwise
      $result = $error->getMessage() . '<br>File: ' . $error->getFile() . '<br>Line: '  . $error->getLine();    // Error - use the methods not array
    }
    return $result;                                                   // Say succeeded
  }

  public function delete($id){
    $pdo = $this->pdo;
    $sql = 'DELETE FROM user WHERE user_id = :id';                 // SQL
    $statement = $pdo->prepare($sql);                             // Prepare
    $statement->bindValue(':id', $id, PDO::PARAM_INT);            // Bind ID
    try {
      $statement->execute();                                      // If executes
      return TRUE;                                                // Say succeeded
    } catch (PDOException $error) {                               // Otherwise
      $result = $error->getMessage() . '<br>File: ' . $error->getFile() . '<br>Line: '  . $error->getLine();    // Error - use the methods not array
    }
  }

  public function getUsersCount() {
    $pdo = $this->pdo;
    $sql = 'SELECT COUNT(*) FROM user';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
    $user = $statement->fetchColumn();
    if (!$user) {
      return null;
    }
    return $user;
  }

  public function getUsers($show='9', $from='0') {
    $pdo = $this->pdo;
    $sql = 'SELECT id, forename, surname, email, joined, role, seo_name, picture FROM user ORDER BY id DESC';
    if (!empty($show)) {             // If value given for $show add
      $sql .= " LIMIT " . $show . " OFFSET " . $from;
    }
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
    $user_list = $statement->fetchAll();
    if (!$user_list) {
      return null;
    }
    return $user_list;
  }

  public function createUserSession($user) {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION['name']     = htmlspecialchars($user->forename);
    $_SESSION['seo_name'] = $user->seo_name;
    $_SESSION['user_id']  = $user->user_id;
    $_SESSION['role']     = $user->role;
  }

  public function getAllUsers() {
    $pdo = $this->pdo;
    $sql = 'SELECT user.user_id, user.forename, user.surname, user.email, user.joined FROM user';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
    $user = $statement->fetchAll();
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

  public function isCurrentUser($seo_name) {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $my_profile = FALSE;
    if ( isset($_SESSION['user_id'])){
      if ($_SESSION['seo_name'] == $seo_name) {
        $my_profile = TRUE;
      }
    }
    return $my_profile;
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

  public function createToken($userId, $purpose) {
    $pdo = $this->pdo;                     // Connect
    $sql = 'SELECT UUID() as token';                          // Tell DB to create UUID
    $statement = $pdo->prepare($sql);                  // Prepare 
    $statement->execute();                                    // Execute
    $token = $statement->fetchColumn();                       // Fetch UUID
    $expires = date("Y-m-d H:i:s", strtotime('+23 hours'));                       // Expiry time - no mbr equivalent
    $sql = 'INSERT INTO token (token, user_id, expires, purpose) 
                 VALUES (:token, :user_id, :expires, :purpose)'; // SQL to add token
    $statement = $pdo->prepare($sql);                       // Prepare
    $statement->bindValue(':token',   $token);                     // Bind value
    $statement->bindValue(':user_id', $userId);                  // Bind value
    $statement->bindValue(':expires', $expires);                   // Bind value
    $statement->bindValue(':purpose', $purpose);                   // Bind value
    try {                                                          // Try block
        $statement->execute();                                        // Execute
        $result = $token;                                             // Worked
    }
    catch (PDOException $error) {                                 // Otherwise
        $result = FALSE;                                              // Error
    }
    return $result;                                                 // Return result
}

  public function sendEmail($to, $subject, $message) {
    try {                                                      // Start a try block
        // Step 1: Create the object
        $mail = new PHPMailer(TRUE);                             // Create object
        // Step 2: How the email is going to be sent
        $mail->IsSMTP();                                         // Set mailer to use SMTP
        $mail->Host     = 'smtp.example.com';                    // SMTP server address
        $mail->SMTPAuth = TRUE;                                  // SMTP authentication on
        $mail->Username = 'chris@example.com';                   // Username
        $mail->Password = 'password';                            // Password
        // Step 3: Who the email is from and to
        $mail->setFrom('no-reply@example.com');                  // From email address
        $mail->AddAddress($to);                                  // To email address
        // Step 4: Content of email  
        $mail->Subject = $subject;                               // Set subject of email
        $mail_header   = '<!DOCTYPE html PUBLIC...';             // Header goes here
        $mail_footer   = '...</html>';                           // Footer goes here
        $mail->Body    = $mail_header . $message . $mail_footer; // Set body of HTML email  
        $mail->AltBody = strip_tags($message);                   // Set plain text body
        $mail->CharSet = 'UTF-8';                                // Set character set
        $mail->IsHTML(TRUE);                                     // Set as HTML email
        // Step 5: Attempt to send email                                 
        $mail->Send();                                     // Send the email
    }
    catch (phpmailerException $error) {                // Code to run if failed to send
        return $error->errorMessage();                     // Return PHPMailer error message
    } 
    return TRUE;                                         // Return TRUE because it sent
}

  public function getUserFromToken($token, $purpose) {
    $pdo = $this->pdo;
    $sql = 'SELECT * from user
           JOIN token ON id = user_id 
           WHERE (token = :token AND purpose = :purpose)';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':token', $token);
    $statement->bindValue(':purpose', $purpose);
    $statement->execute();
    if($statement->errorCode() != 0) {  
        return $statement->errorCode();
    } else {
        $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');               
        $user = $statement->fetch();
        if ($user) {
          $expires = new DateTime($user->expires);
          $now = (new DateTime())->format('Y-m-d H:i:s');
          if($now<$expires) {
            return $user;
          }   
        }
    }
    return false;
}

  public function updatePassword($userId,$password) {
    $pdo = $this->pdo;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'UPDATE user SET password = :password WHERE user_id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':password', $hash);
    $statement->bindValue(':id', $userId);
    try {
        $statement->execute();
        return TRUE;
    }
    catch (PDOException $error) {
        return FALSE; 
    }
}

}