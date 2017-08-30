<?php 
  ini_set('display_errors', '1');
  error_reporting(E_ALL);
  function total($price, $quantity = 1) {
    return $price * $quantity;
  }
  /*  function calculateTax($amount, $rate) {
        $price * $quantity;
  }   */
  $total = total(4,5);
/*  $tax = calculateTax($total, 0.2); */
?>
<h1>Basket</h1>
Total $<?php echo $total; ?><br>
Tax $<?php // echo $tax; ?>
