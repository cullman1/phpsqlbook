<?php

class UserManager
{

  private $pdo;
  const role_user = 1;
  const role_admin = 2;

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

  public function get_user_by_email_password($email, $password) {
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
  return (password_verify($password, $user->getPassword()) ? $user : FALSE);
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

public function get_tasks($role_id) {
    $pdo = $this->pdo;
    $query = 'SELECT task.name FROM task 
              JOIN tasks_in_role ON task.id = tasks_in_role.task_id              
              WHERE tasks_in_role.role_id = :roleid';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':roleid', $role_id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $tasks = $statement->fetchAll();
    if (!$tasks) {
        return null;
    }
    return $tasks;
}

function create_user_session($user) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['name']    = $user->forename;
    $_SESSION['user_id'] = $user->id;
    $_SESSION['role']    = $user->role_id;
}

public function isLoggedIn() {
  session_start();
  return (isset($_SESSION['user_id']) ? TRUE : FALSE);  
}

public function redirectNonAdmin() {
    if (!isset($_SESSION['role'])) {
        header('Location: /phpsqlbook/cms/login');
        exit;
    } else {
        if ($_SESSION['role'] != self::role_admin ) {
            header('Location: /phpsqlbook/cms/404');
            exit;
        }
    }
}

function getUserFromToken($token, $purpose) {
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
        $expires = new DateTime($user->expires);
        $now = (new DateTime())->format('Y-m-d H:i:s');
        if($now<$expires) {
            return $user;
        }   
    }
    return false;
}

public function createToken($userId, $purpose) {
    $pdo = $this->pdo;                     // Connect
    $sql = 'SELECT UUID() as token';                          // Tell DB to create UUID
    $statement = $pdo->prepare($sql);                  // Prepare 
    $statement->execute();                                    // Execute
    $token = $statement->fetchColumn();                       // Fetch UUID
    $expires = date("Y-m-d H:i:s", strtotime('+23 hours'));                       // Expiry time
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

function sendEmail($to, $subject, $message) {
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

function updatePassword($userId,$password) {
    $pdo = $this->pdo;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'UPDATE user SET password = :password WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':password', $hash);
    $statement->bindParam(':id', $userId);
    try {
        $statement->execute();
        return TRUE;
    }
    catch (PDOException $error) {
        return FALSE; 
    }
}


}

