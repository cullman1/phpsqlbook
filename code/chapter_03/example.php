<?php
define('TAX', 22);

$toffee = array('name' => 'Toffee', 'price' => 3, 'stock' => 12);
$mints  = array('name' => 'Mints',  'price' => 2, 'stock' => 26);
$fudge  = array('name' => 'Fudge',  'price' => 4, 'stock' => 8);

$products = array($toffee, $mints, $fudge);

function get_stock_value($price, $quantity) {
  return $price * $quantity;
}

function get_tax($price, $tax_rate) {
  return ($price / 100) * $tax_rate;
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <table>
    <tr>
      <th>Product</th><th>Price</th><th>Stock</th><th>Total value</th><th>Tax due</th>
    </tr>
    <?php
    foreach ($products as $product) {
      echo '<tr>';
      foreach ($product as $key => $value) {
        echo '<td>';
        if ($key=='price') { 
          echo '$'; 
        }
        echo $value . '</td>';
      }
      echo '<td>$' . get_stock_value($product['price'], $product['stock']) . '</td>';
      echo '<td>$' . get_tax($product['price'], TAX) . '</td>';
      echo '</tr>';
    }
    ?>
  </table>
</body>
</html>