<?php
			        $token  = ( isset($_REQUEST['token'])  ? $_REQUEST['token']  : '' ); 
                    $iv  = ( isset($_REQUEST['iv'])  ? $_REQUEST['iv']  : '' ); 

                    function create_iv() {
						$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,MCRYPT_MODE_CBC);
 						$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  					    return $iv;
					}

                    function create_url($token, $iv) {
                        $iv = rawurlencode(base64_encode($iv));
                        $token = rawurlencode(base64_encode($token));
                        $message="<a href='http://test1.phpandmysqlbook.com/code/chapter_09/encryption.php?token=".$token."&iv=".$iv."'>Link with encrypted token - click to decrypt</a>"; 
                        return $message;
					}

					function encrypt_data($message, $iv) {
  					    $key = 'kE8vew3Jmsvd7Fgh';
  					    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$key , $message, MCRYPT_MODE_CBC, $iv);
  					    return $ciphertext;
					}
					
					function decrypt_data($encrypted_message, $iv) {
                        $encrypted_message = base64_decode($encrypted_message);
                        $iv = base64_decode($iv);
  					    $key = 'kE8vew3Jmsvd7Fgh';
   					    $decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encrypted_message, MCRYPT_MODE_CBC, $iv);
                      
   					    return $decrypted_string;
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
                    }
?>