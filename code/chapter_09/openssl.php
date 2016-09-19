<?php
$token  = (isset($_GET['token']) ? $_GET['token'] : '' ); 
$iv     = (isset($_GET['iv']) ? $_GET['iv'] : create_iv() ); 
define ('METHOD', 'AES-128-CBC');
define ('KEY', 'kE8vew3Jmsvd7Fgh');

function create_iv() {
  $isItSecure = false;
  while ($isItSecure == false) {
    $iv = openssl_random_pseudo_bytes(16, $isItSecure);
    if ($isItSecure) {
      return $iv;
    } 
  }
}

if($token=='') { // Encrypt message
  $message = 'ivy@example.org' . '#' . time();
  $token   = openssl_encrypt($message, METHOD, KEY, OPENSSL_RAW_DATA, $iv);
  // Encode token and create link
  $token = rawurlencode(base64_encode($token));
  $iv    = rawurlencode(base64_encode($iv));
  $link  = '<a href="?token=' . $token . '&iv=' . $iv . '">Decrypt message</a>'; 
  // Write message to page
  echo 'Before encryption: ' . $message . '<br>';
  echo 'After encryption: ' . $token . '<br>';
  echo $link;
 } else {
  // Decrypt message
  $token   = base64_decode($token);
  $iv      = base64_decode($iv);
  $message = openssl_decrypt($token, METHOD, KEY, OPENSSL_RAW_DATA, $iv);
  // Turn message into array and show parts
  $items   = explode('#', $message);
  echo 'Decrypted email: ' . $items[0] . '<br>';
  echo 'Seconds since encryption: ' . (time() - $items[1]) . ' seconds';
 }
?>