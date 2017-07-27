  <?php 
  ini_set('display_errors', '1');
  error_reporting(E_ALL);
  ?>
  <h1>Basket</h1>
  <?php
  class date {
     private $now;
     public function __construct($now) {
      $this->now = $now;
     }
   
      
     public static function format($new) {
       return $new++;
     }
  }

  function ag()
{
    echo '2';
}


echo AG();

echo Date::format(3);
 