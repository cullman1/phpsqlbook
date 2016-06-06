
        <?php
       // set default timezone
//date_default_timezone_set('America/Chicago'); // CDT

$current_date = date('d/m/Y == H:i:s');
            echo $current_date."<br/>";
       

         if (isset($_COOKIE["Cookie1"])) {
                   echo "Cookie1 ".$_COOKIE["Cookie1"]."<br/>";
        }

        if (isset($_COOKIE["Cookie2"])) {
                 echo "Cookie2 ".$_COOKIE["Cookie2"]."<br/>";
        }

        if (isset($_COOKIE["Cookie3"])) {
                  echo "Cookie3 ".$_COOKIE["Cookie3"]."<br/>";
        }

        if (isset($_COOKIE["Cookie4"])) {
                 echo "Cookie4 ".$_COOKIE["Cookie5"]."<br/>";
        }

        if (isset($_COOKIE["Cookie5"])) {
           echo "Cookie5 ".$_COOKIE["Cookie5"]."<br/>";
        }
				
				 if (isset($_COOKIE["Cookie6"])) {
           echo "Cookie6 ".$_COOKIE["Cookie6"]."<br/>";
        }

       
        ?>


