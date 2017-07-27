 <?php 
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    $quantity=2;
  ?>
  <h1>Basket</h1>
  <?php
    function total($price, $quantity){
      return $price * $quantity;
    }

   echo total(3);
 ?>