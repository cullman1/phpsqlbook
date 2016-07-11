<?php
			function create_iv() {
						$iv_size 	= mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,MCRYPT_MODE_CBC);
 						$iv 			= mcrypt_create_iv($iv_size, MCRYPT_RAND);
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
					echo "Message: ".$message ."<br/>";
					$iv = create_iv();
					$encrypted_message = encrypt_data($message, $iv) ."<br/>";
					echo "Encrypted message: ".$encrypted_message;
					$decrypted_message = decrypt_data($encrypted_message, $iv) ."<br/>";
					echo "Decrypted message: ".rtrim($decrypted_message,"\0");

?>