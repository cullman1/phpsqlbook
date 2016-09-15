<?php error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
setcookie("tomorrowExpireCodePath","3333", time() + (43200* 1),'code/','test1.phpandmysqlbook.com');
                setcookie("tomorrowExpireNoPath","5555",time() + (43200* 1),'test1.phpandmysqlbook.com');
                      setcookie("tomorrowExpireNoExpiry","5535",time() + (1800* 1));
                     setcookie("tomorrowExpireRootPath","5535",time() + (43200* 1),'/','test1.phpandmysqlbook.com');

          $cookie1 =   filter_input_array(INPUT_COOKIE, 'tomorrowExpireCodePath', FILTER_DEFAULT); 
               $cookie2 =   filter_input(INPUT_COOKIE, 'tomorrowExpireNoPath', FILTER_DEFAULT); 
                              $cookie3 =   filter_input(INPUT_COOKIE, 'tomorrowExpireNoExpiry', FILTER_DEFAULT); 
                                             $cookie4=   filter_input(INPUT_COOKIE, 'tomorrowExpireRootPath', FILTER_DEFAULT); 
                                              $cookie5=   filter_input(INPUT_COOKIE, 'emptycookie', FILTER_DEFAULT); 
                                              $cookie6=   filter_input(INPUT_COOKIE, 'lala', FILTER_DEFAULT); 
            echo "cookie1" .$cookie1[0] ."</br>";
       
           echo "cookie2".$cookie2."</br>";
       
            echo "cookie3".$cookie3."</br>";
       
           echo "cookie4".$cookie4."</br>";
        echo "cookie5".$cookie5."</br>";
       echo "emptycookie".$cookie6."</br>";
       if ($cookie6) {echo "true"; } else { echo "false"; }
        ?>
       

