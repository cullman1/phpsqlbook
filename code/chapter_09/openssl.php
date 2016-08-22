<?php 
$token= (isset($_GET['token']) ? $_GET['token'] : '' ); 
$iv   = (isset($_GET['iv']) ? $_GET['iv'] : '' ); 


function create_url($token, $iv) {
  $iv = rawurlencode(base64_encode($iv));
  $token = rawurlencode(base64_encode($token));
  $message="<a href='http://test1.phpandmysqlbook.com/code/chapter_09/openssl.php?token=".$token."&iv=" .$iv."'>Link with token - click to decrypt</a>"; 
  return $message;
}

function encrypt_data($message, $iv) {
  $password = 'kE8vew3Jmsvd7Fgh';
  //$method  = openssl_get_cipher_methods() ;
  $encrypt = openssl_encrypt($message, "AES-128-CBC", $password, OPENSSL_RAW_DATA, $iv);
  return $encrypt;
}

function decrypt_data($encrypted_message, $iv) {
  $encrypt = base64_decode($encrypted_message);
  $iv = base64_decode($iv);
  $password = 'kE8vew3Jmsvd7Fgh';
 //$method  = openssl_get_cipher_methods() ; 			   
  $decrypt = openssl_decrypt($encrypt, "AES-128-CBC", $password, OPENSSL_RAW_DATA, $iv);      
  return $decrypt;
}

function create_iv() {
  $wasItSecure = false;
  while ($wasItSecure == false) {
    $iv = openssl_random_pseudo_bytes(16, $wasItSecure);
    if ($wasItSecure) {
      return $iv;
    } 
  }
}



if($token=='') {
              $message = "bob@example.org" ."#". time();
              echo "Data before encryption: ".$message ."<br/><br/>";
              $iv = create_iv();
              $encrypted_message = encrypt_data($message, $iv);
              echo "Encrypted data: ".$encrypted_message ."<br/><br/>";
              $link = create_url($encrypted_message, $iv);
              echo "".$link;
           } else {
              $decrypted_message = decrypt_data($token, $iv) ."<br/>";
              echo "Decrypted message: ".$decrypted_message."<br/>";
              $items = explode("#" ,$decrypted_message);
              echo "Decrypted email: ".$items[0]."<br/><br/>";
              $time_elapsed = time() - $items[1];
              echo "Time since encrypted in seconds: ".$time_elapsed."<br/>";
           } ?>