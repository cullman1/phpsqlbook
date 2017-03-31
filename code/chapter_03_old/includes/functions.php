<?php
function calculate_cost($cost, $quantity) {
  return $cost * $quantity;
}

function get_stock_indicator($stock) {
  if ($stock >= 10) {
    return 'Good availability';
  }
  if ($stock > 0 && $stock < 10) {
    return 'Low stock';
  }
  return 'Out of stock';
}
?>