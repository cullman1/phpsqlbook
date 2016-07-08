<?php
		function create_iv() {
 						 $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
  					return $iv;
					}

					function encrypt_data($message, $iv) {
  					$key = 'ThisIsACipherKey';
  					$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$key , $message, MCRYPT_MODE_CBC, $iv);
  					return $ciphertext;
					}
					
					function decrypt_data($encrypted_message, $iv) {
  					$key = 'ThisIsACipherKey';
   					$decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encrypted_message, MCRYPT_MODE_CBC, $iv);
   					return $decrypted_string;
					}
					
					$message = "This is our secret message";
					echo $message ."<br/>";
					$iv = create_iv();
					$encrypted_message = encrypt_data($message, $iv) ."<br/>";
					echo $encrypted_message;
					$decrypted_message = decrypt_data($encrypted_message, $iv) ."<br/>";
					echo $decrypted_message;

?>