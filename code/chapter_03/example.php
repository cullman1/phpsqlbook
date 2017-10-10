<?php
define('TAX', 22);

$toffee = array('name' => 'Toffee', 'price' => 3, 'stock' => 12);
$mints  = array('name' => 'Mints',  'price' => 2, 'stock' => 26);
$fudge  = array('name' => 'Fudge',  'price' => 4, 'stock' => 8);

$products = array($toffee, $mints, $fudge);

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
    echo '<td>$' . $product['price'] * $product['stock'] . '</td>';
    echo '<td>$' . ($product['price'] / 100) * TAX . '</td>';
    echo '</tr>';
  }
?>
  </table>
  </body>
</html>