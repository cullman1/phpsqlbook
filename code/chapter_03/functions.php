<?php
 $tax = 22;

function product_create($name, $price, $stock) {
  $row =  '<tr>';
  $row .= '<td>' . $name . '</td>';
  $row .= '<td>$' . $price . '</td>';
  $row .= '<td>' . $stock . '</td>';
  $row .= '<td>$' . combined_total($price, $stock) . '</td>';
  $row .= '<td>' . get_stock_indicator($stock) . '</td>';
  return $row;
}

function combined_total($price, $quantity) {
    global $tax;
    static $combined_total;
    $total = ($price * $quantity) + 
             (($price * $quantity) / 100) * $tax;
    $combined_total = $combined_total + $total;
    return $combined_total;
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
?>
<!DOCTYPE html>
<html>
  <head>
    <title>The Candy Store</title>
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
echo product_create('Toffee',3 , 12);
echo product_create('Mints',2 , 26);
echo product_create('Fudge',4 , 8);
?>

</table>
  </body>
</html>