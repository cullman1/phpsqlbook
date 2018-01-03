<?php
$tax = 22;

function running_total($price, $quantity = 1) {
    global $tax;
    static $running_total;
    $total = ($price * $quantity) + 
             (($price * $quantity) / 100) * $tax;
    $running_total = $running_total + $total;
    return $running_total;
  }

function get_stock_indicator($quantity) {
  if ($quantity >= 10) {
    return 'Good availability';
  }
  if ($quantity > 0 && $quantity < 10) {
    return 'Low stock';
  }
  return 'Out of stock';
}
function create_product_row($name, $price, $quantity) {
  $row = '<tr>';
  $row .= '<td>' . $name . '</td><td>$' . $price . '</td><td>' . $quantity . '</td>';
  $row .= '<td>$' . running_total($price, $quantity) . '</td>';
  $row .= '<td>' . get_stock_indicator($quantity) . '</td>';
  $row .= '</tr>';
  return $row;
} 
?>
<!DOCTYPE html>
<html> 
  <head>
    <title>Functions example</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Stock Control</h2>
    <table>
      <tr>
        <th>Product</th><th>Price</th><th>Stock</th><th>Total value</th><th>Stock Level</th>
      </tr>
      <?php
        echo create_product_row('Toffee', 3, 12);
        echo create_product_row('Mints', 2, 26);
        echo create_product_row('Fudge', 4, 8);
      ?>
    </table>
  </body>
</html>