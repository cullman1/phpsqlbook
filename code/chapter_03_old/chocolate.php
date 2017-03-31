<?php 
  $cost     = 5;
  $stock    = 25;
  $quantity = 3;

  require_once('/includes/functions.php');
  include('/includes/header.php');

?>
<h2>Chocolate</h2>
<?php 

echo calculate_cost($cost, $quantity);
echo get_stock_indicator($stock);

  include('includes/footer.php');
?>