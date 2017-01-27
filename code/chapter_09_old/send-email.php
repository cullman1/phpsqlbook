<?php
require('../includes/functions.php');
require('../vendor/PHPMailer/PHPMailerAutoload.php');        // Include PHPMailer

$to      = 'chris@deciphered.com';                                // To address
$subject = 'Welcome to our website';                         // From address
$message = 'The welcome message goes here';                  // Message

$result  = send_email($to, $subject, $message);              // Try to sent it

if ($result) {                                               // Sent: store success msg
  $alert = Array('status'  => 'success', 'message' => 'Email sent.'); 
} else {                                                     // Not sent: store fail msg
  $alert = Array('status'  => 'danger', 'message' => 'Cannot send email.'); 
}
echo '<div class="' . $alert['status'] . '">' .  $alert['message'] . '</div>';
?>