<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../includes/config.php');
require_once('/classes/user.php');
require_once('../includes/database_connection.php');
require_once('../vendor/PHPMailer/PHPMailerAutoload.php');
// Check form data
$show_form = true;
$subject = 'Your password has been updated';
$message = 'Your password was updated on ' . date("Y-m-d H:i:s");
$password  = (isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = (isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
$iv        = (isset($_REQUEST['iv'])    ? $_REQUEST['iv']    : '' ); 
$token     = (isset($_REQUEST['token']) ? $_REQUEST['token'] : '' ); 

// Functions
function validate_form($password, $confirm) {
  // Does the password have 8 characters, upper and lower cases and digits?
  $valid  = (filter_var($password, FILTER_VALIDATE_REGEXP, array('options' => array('regexp'=>'/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/' )))  ? '' : 'Your password is not strong enough. ');
  // Is the password confirm box empty
  $valid .= (filter_var($confirm, FILTER_DEFAULT)) ? '' : 'Confirm password empty. ';
  // If neither check is positive then compare password to confirm password
  if ($valid == '') {
    $valid = ($password == $confirm ? '' : 'Passwords do not match' );
  }

  // Return the result of validation
  return ( ($valid == '') ? true : $valid );
}

function get_user_by_email($email) {
  $query = 'SELECT * from user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');     // Object
    $user = $statement->fetch();
  }
  return ($user ? $user : false);
}  // As shown on pXXX

function send_email($to, $subject, $message) {
try {
  $mail = new PHPMailer(true);                                 // Create object
  // How the email is going to be sent
  $mail->IsSMTP();                                         // Set mailer to use SMTP
    $mail->Host     = 'secure.emailsrvr.com';                    // SMTP server address
  $mail->SMTPAuth = true;                                  // SMTP authentication on
  $mail->Username = 'test@deciphered.com';                   // Username
  $mail->Password = 'M3f2gs_egWJF2!';                            // Password
  // Who the email is from and to
  $mail->setFrom('test@deciphered.com');  
  $mail->AddAddress($to);                                  // To
  // Content of email
  $mail_header   = '<!DOCTYPE html PUBLIC...';             // Header goes here
  $mail_footer   = '...</html>';                           // Header goes here
  $mail->Subject = $subject;                               // Set subject of email
  $mail->Body    = $mail_header . $message . $mail_footer; // Set body of HTML email  
  $mail->AltBody = strip_tags($message);                   // Set plain text body
  $mail->CharSet = 'UTF-8';                                // Set character set
  $mail->IsHTML(true);                                    // Set as HTML email
  $mail->Send();
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
  return false;
} 
  return true;                                             // Otherwise return false
}

// Check 1: Has form been submitted?  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Set default error message
  $alert = array('status' => 'danger', 'message' => 'Check errors and try again');
  // Check 2: Is form valid?  
  if (validate_form($password, $confirm)===true) {    
    // If success set new default error message, as form has no errors
    $alert = array('status' => 'danger', 'message' => 'Password not updated');
    // Check 3: Try to get email and store it in $email
    $email = get_email_from_token($token, $iv);       
    if ($email) {  
      // If success Check 4: Try to get user and store in $user                                     
      $user = get_user_by_email($email);     
if ($user) {       
        // If success Check 5: Try to update password                               
        if (update_password($password, $user->id)===true) {   
          // If success set success message, hide form and send email.
          $alert     = array('status' => 'success', 'message' => 'Password updated');
          $show_form = false;
          send_email($email, $subject, $message); 
        }
      }
    } 
  } 
}

function get_email_from_token($token, $iv) {
  $token = base64_decode($token);
  $iv    = base64_decode($iv);
  $token = openssl_decrypt($token, METHOD, KEY, 
                           OPENSSL_RAW_DATA, $iv);
  if (strlen($token) != 0) { 
    $items = explode('#', $token);
    if( is_timestamp_valid($items[1], 86400) ) {
      return  $items[0];
    }
  }
  return false;
}

function is_timestamp_valid($timestamp, $seconds) {
  return ( ( (time() - $timestamp) <= $seconds) 
          ? true : false );
}

function update_password($password, $id){
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = 'UPDATE user set password = :password 
          WHERE id = :id';
  $statement = $GLOBALS['connection']->prepare($sql);
  $statement->bindParam(':password', $hash);
  $statement->bindParam(':id', $id);
  $statement->execute();

  if($statement->errorCode() != 0) {  
    return $statement->errorCode();
  }
  return true;
} 

if (isset($alert)) { ?>
<div class="<?= $alert['status']; ?>"><?= $alert['message']; ?><br><?= $valid ?></div>
<?php 
}
if ($show_form == true) { ?>
  <form method="post" action="reset-password.php">
    <h1>Reset Your Password</h1>
    <label>Enter Your Password: <input type="password" name="password" /></label><br/>
    <label>Confirm Your Password: <input type="password" name="confirm" /></label><br/> 
    <input type="hidden" name="token" value="<?= $token ?>" />
    <input type="hidden" name="iv" value="<?= $iv ?>" />
    <input type="submit" name="submit_button" value="Submit New Password" />
  </form>			
<?php } ?>