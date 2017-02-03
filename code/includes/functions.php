<?php

function add_user($forename, $surname, $password, $email) {     
  $query = 'INSERT INTO user (forename, surname, email, password) 
    VALUES ( :forename, :surname, :email, :password)';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':forename', $forename );
  $statement->bindParam(':surname', $surname );
  $statement->bindParam(':email',$email);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $statement->bindParam(':password',$hash);
  $result = $statement->execute();
  return (($result == true) ? true : $statement->errorCode());   
 }

function is_logged_in() {
  if (isset($_SESSION["forename"])) {
    return true;
  } else {
    return false;
  }
}

function get_user_by_email($email) {
  $query = 'SELECT * from user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');            
    $user = $statement->fetch();
  }
  return ($user ? $user : false);
}

function send_email($to, $subject, $message) {
try {
  $mail = new PHPMailer(true);                             // Create object
  // Step 2: How the email is going to be sent
  $mail->IsSMTP();                                         // Set mailer to use SMTP
  $mail->Host     = 'smtp.example.com';                    // SMTP server address
  $mail->SMTPAuth = true;                                  // SMTP authentication on
  $mail->Username = 'chris@example.com';                   // Username
  $mail->Password = 'password';                            // Password
  // Step 3: Who the email is from and to
  $mail->setFrom('no-reply@example.com');                  // From
  $mail->AddAddress($to);                                  // To
  $mail_header   = '<!DOCTYPE html PUBLIC...';             // Header goes here
  $mail_footer   = '...</html>';                           // Header goes here
  // Step 4: Content of email  
  $mail->Subject = $subject;                               // Set subject of email
  $mail->Body    = $mail_header . $message . $mail_footer; // Set body of HTML email  
  $mail->AltBody = strip_tags($message);                   // Set plain text body
  $mail->CharSet = 'UTF-8';                                // Set character set
  $mail->IsHTML(true);                                     // Set as HTML email
  // Step 5: Attempt to send email                                 
  $mail->Send();
} catch (phpmailerException $e) {
    echo $e->errorMessage();                              //Error message from PHPMailer
  return false;
} 
  return true;     
}

function get_tasks_by_role_id($role_id) {
  $query = 'SELECT task.id, task.name FROM task 
            JOIN tasks_in_role ON task.id = tasks_in_role.task_id 
            WHERE tasks_in_role.role_id = :roleid';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':roleid', $role_id);
  $statement->execute();
  $task = $statement->fetchAll(PDO::FETCH_ASSOC);
  return ($task ? $task : false);
}

function create_session($user) {				  
  session_start();
  $_SESSION['forename'] = $user->forename;
  $_SESSION['image'] =($user->image ? $user->image : 'default.jpg');
  $_SESSION['tasks'] = get_tasks_by_role_id($user->role_id);
}



function get_article_list() { // Return all images as an object
  $query = 'SELECT article.*, filepath, alt, name
            FROM article
            LEFT JOIN media ON article.media_id = media.id
            LEFT JOIN category ON article.category_id = category.id' ;  // Query
  $statement = $GLOBALS['connection']->prepare($query);                 // Prepare
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $article_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $article_list;
}

function get_user_by_email_passwordhash($email, $password) {
  $query = 'SELECT * FROM user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email',$email);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  if (!$user) { 
    return false; 
  }
  return (password_verify($password, $user->password) ? 
  $user : false);
}

function create_user_session($user) {
  $_SESSION['forename'] = $user->forename;
  $_SESSION['image']  = ($user->image ? $user->image 
                         : 'default.jpg');
  $_SESSION['loggedin'] = $user->joined;
}

function logout_user() {
 $_SESSION = array();
 setcookie(session_name(),'', time()-3600, '/');
}

?>