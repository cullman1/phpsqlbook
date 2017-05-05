<?php
         $locale = array('timezone' => 'EST',
                'language' => 'EN-US',    'currency' => 'USD');
          $_SESSION = $locale;
if (empty($_SESSION["name"]["first"])) {
         echo "1";                 
}
if (!isset($_SESSION["name"]["first"])) {
                  echo "2";        
}


?>
