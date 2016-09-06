<?php 
$token= (isset($_GET['token']) ? $_GET['token'] : '' ); 
$iv   = (isset($_GET['iv']) ? $_GET['iv'] : '' ); 




function encrypt_data($message, $iv) {
  $password = 'kE8vew3Jmsvd7Fgh';
  //$method  = openssl_get_cipher_methods() ;
  $encrypt = openssl_encrypt($message, "AES-128-CBC", $password, OPENSSL_RAW_DATA, $iv);
  return $encrypt;
}

function print_data() {
  
  $method  = openssl_get_cipher_methods() ; 			   
  foreach ($method as $val) {
  echo ($val . "<br/>");
  }   
  }
 





print_data(); ?>