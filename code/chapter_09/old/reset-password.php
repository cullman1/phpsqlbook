<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');
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
  $valid  = (filter_var($password, FILTER_VALIDATE_REGEXP,  array('options' => array('regexp'=>'/^(?=\S*\d)(?=\S*[a-zA-Z])\S{8,}$/' )))  ? '' : 'Your password is not strong enough. ');
  // Is the password confirm box empty
  $valid .= (filter_var($confirm, FILTER_DEFAULT)) ? '' : 'Confirm password empty. ';
  // If neither check is positive then compare password to confirm password
  if ($valid == '') {
    $valid = ($password == $confirm ? '' : 'Passwords do not match' );
  }
  // Return the result of validation
  return ( ($valid == '') ? true : $valid );
}
function get_email_from_token($token, $iv, $valid) {
  $token = base64_decode($token);
  $iv    = base64_decode($iv);
  $token = openssl_decrypt($token, METHOD, KEY, OPENSSL_RAW_DATA, $iv);
  if (strlen($token) != 0) { 
    $items = explode('#', $token);
    if( is_timestamp_valid($items[1], 86400) ) {
      return  $items[0];
    }
  }
  return false;
}
function is_timestamp_valid($timestamp, $seconds) {
  return (((time() - $timestamp) <= $seconds) ? true : false );
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Set default error message
  $alert = array('status' => 'danger', 'message' => 'Check errors and try again');

  $valid = validate_form($password, $confirm);            // Check: is form valid

  if ($valid) {                                       // If success

    // Set new default error message
    $alert = array('status' => 'danger', 'message' => 'Password not updated');

    $email = get_email_from_token($token, $iv, $valid);   // Try to get email
    if ($email) {                                         // If success

      $user    = get_user_by_email($email);               // Try to get user
      if ($user) {                                        // If success

        $updated = update_password($password, $user->id); // Try to update password
        if ($updated) {                                   // If success

          // Set success message
          $alert     = array('status' => 'success', 'message' => 'Password updated');
          $show_form = false;
          send_email($email, $subject, $message); 

        }
      }
    } 
  } 
}

if (isset($alert)) {
?>
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