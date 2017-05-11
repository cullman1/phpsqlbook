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
  session_start();
  $_SESSION['name'] = $user->forename;
  $_SESSION['user_id']  = $user->id;
  $_SESSION['tasks']    = get_tasks($user->role_id);
  
}

   function get_tasks($role_id) {
    $connection = $GLOBALS['connection'];
    $query = 'SELECT name FROM task 
              JOIN tasks_in_role ON task.id = tasks_in_role.task_id 
              WHERE tasks_in_role.role_id = :roleid';
                  $statement = $connection->prepare($query);
    $statement->bindValue(':roleid',$role_id);
    $statement->execute();
    $tasks = $statement->fetchAll(PDO::FETCH_COLUMN);
    return $tasks;
  }

function has_permission($task) {
  return in_array($task, $_SESSION['tasks']);  // For each task
}

function get_user_from_token($token, $purpose) {
   $connection = $GLOBALS['connection'];
   $sql = 'SELECT * from user
           JOIN token ON id = user_id 
           WHERE (token = :token AND purpose = :purpose)';
  $statement = $connection->prepare($sql);
   $statement->bindValue(':token', $token);
      $statement->bindValue(':purpose', $purpose);
   $statement->execute();
   if($statement->errorCode() != 0) {  
     return $statement->errorCode();
   } else {
      $statement->setFetchMode(PDO::FETCH_OBJ);               
      $user = $statement->fetch();
      $expires = new DateTime($user->expires);
      $now = (new DateTime())->format('Y-m-d H:i:s');
      if($now<$expires) {
          return $user;
      }   
    }
    return false;
 }

function update_password($password, $id) {
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = 'UPDATE user SET pasword = :password WHERE id = :id';
  $statement = $GLOBALS['connection']->prepare($sql);
  $statement->bindParam(':password', $hash);
  $statement->bindParam(':id', $id);
  try {
    $statement->execute();
    $result = TRUE;
  } catch (PDOException $error) {
    $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2]; 
  }
  return $result;
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

function get_article_list() {
    $connection = $GLOBALS['connection'];

    $query = 'SELECT article.id, article.title, article.media_id, article.published, category.name,
      media.id, media.filepath, media.thumb, media.alt, media.type
      FROM article
      LEFT JOIN media ON article.media_id = media.id  LEFT JOIN category ON article.category_id = category.id';                   // Query
    $statement = $connection->prepare($query); 
    $statement->execute();                              // Execute
    $statement->setFetchMode(PDO::FETCH_OBJ);           // Object
    $article_list = $statement->fetchAll();             // Fetch

    return ($article_list == false ? false : $article_list);
  }

  function send_email($to, $subject, $message) {
try {
  // Step 1: Create the object
  $mail = new PHPMailer(true);                             // Create object
  // Step 2: How the email is going to be sent
  $mail->IsSMTP();                                         // Set mailer to use SMTP
        $mail->Host     = 'secure.emailsrvr.com';                    // SMTP server address
  $mail->SMTPAuth = true;                                  // SMTP authentication on
  $mail->Username = 'test@deciphered.com';                   // Username
  $mail->Password = 'M3f2gs_egWJF2';                          // Password
  // Step 3: Who the email is from and to
  $mail->setFrom('no-reply@example.com');                  // From
  $mail->AddAddress($to);                                  // To
  // Step 4: Content of email  
  $mail->Subject = $subject;                               // Set subject of email
  $mail_header   = '<!DOCTYPE html PUBLIC...';             // Header goes here
  $mail_footer   = '...</html>';                           // Footer goes here
  $mail->Body    = $mail_header . $message . $mail_footer; // Set body of HTML email  
  $mail->AltBody = strip_tags($message);                   // Set plain text body
  $mail->CharSet = 'UTF-8';                                // Set character set
  $mail->IsHTML(true);                                     // Set as HTML email
  // Step 5: Attempt to send email                                 
  $mail->Send();
} catch (phpmailerException $e) {
    return $e->errorMessage();                            //Error message from PHPMailer
} 
  return true;     
}


?>