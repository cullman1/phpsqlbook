 <?php 
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
  ?>
  <h1>Basket</h1>
  <?php
    function total($price, $quantity){
      return $price * $quantity;
    }

   echo totals(3,5);
 ?>