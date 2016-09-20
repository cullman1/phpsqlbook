<?php

function add_user($forename, $surname, $password, $email) {     
  $query = "INSERT INTO user (forename, surname, email, password) 
            VALUES (:forename, :surname, :email, :password)";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(":forename", $forename );
  $statement->bindParam(":surname", $surname );
  $statement->bindParam(":email",$email);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $statement->bindParam(":password",$hash);
  $result = $statement->execute();
  if( $result == true ) {     
      return true;
  } else {
      return $statement->errorCode();
  }	   
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
  $statement->execute();
  $user =   $statement->fetch(PDO::FETCH_OBJ);
  return ($user ? $user : false);
}

function send_email($to, $subject, $message) {
  $mail = new PHPMailer();                                 // Create object
  // How the email is going to be sent
  $mail->IsSMTP();                                         // Set mailer to use SMTP
  $mail->Host     = 'secure.emailsrvr.com';                    // SMTP server address
  $mail->SMTPAuth = true;                                  // SMTP authentication on
  $mail->Username = 'test@deciphered.com';                   // Username
  $mail->Password = 'Ma8_d3vwjX12j';                            // Password
  // Who the email is from and to
  $mail->setFrom('no-reply@example.com');                  // From
  $mail->AddAddress($to);                                  // To
  // Content of email
    $mail_header= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style type="text/css">#outlook a{padding:0}body{width:100%!important}.ReadMsgBody{width:100%}.ExternalClass{width:100%}body{-webkit-text-size-adjust:none}body{margin:0;padding:0}table td{border-collapse:collapse}body{background-color:#efefef}td.message{background-color:#FFF;color:#202020;font-family:Arial;font-size:16px;line-height:150%;padding:20px;text-align:left}a .yshortcuts,a:link,a:visited{color:#096;font-weight:400;text-decoration:underline}</style></head><body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"><center><table border="0" cellpadding="0" cellspacing="0" class="container" height="100%" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="600"><tr><td class="header"><img src="email-header.png" style="max-width:600px"></td></tr><tr><td align="left" class="message">';
  $mail_footer= '</td></tr></table></td></tr></table></center></body></html>';

  $mail->Subject = $subject;                               // Set subject of email
  $mail->Body    = $mail_header . $message . $mail_footer; // Set body of HTML email  
  $mail->AltBody = strip_tags($message);                   // Set plain text body
  $mail->CharSet = 'UTF-8';                                // Set character set
  $mail->IsHTML(true);                                    // Set as HTML email
  // Attempt to send email
  if(!$mail->Send()) {
    return false;                                          // If it fails return false
  }
  return true;                                             // Otherwise return false
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
  return (password_verify($password, $user->hash) ? $user : false);
}

?>