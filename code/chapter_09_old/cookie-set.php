<?php setcookie("Cookie1","1111", time() + (60* 1),'code/','http://test1.phpandmysqlbook.com');
          setcookie("Cookie2","2222",time() + (60* 1),'http://test1.phpandmysqlbook.com');
          $locale = array('timezone' => 'EST', 'language' => 'EN-US', 'currency' => 'USD');
          setcookie("Cookie3",$locale,time() + (60* 1));
          setcookie("Cookie4","4444",time() - (60* 1));
          setcookie("Cookie5","5555");
					echo "Interrupting text";
					setcookie("Cookie6","6666");
          echo "Cookies set";
        ?>