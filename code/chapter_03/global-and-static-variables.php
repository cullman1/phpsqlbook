<?php
  $tax = 20;

  function combined_total($price, $quantity) {
    global $tax;
    static $combined_total;
    $total =  ($price * $quantity) + (($price * $quantity) / 100) * $tax;
    $combined_total = $combined_total + $total;
    return $combined_total;
  }
?>
<!doctype html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>The Candy Store</h1>
  <table>
    <tr>
      <th>Item</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Combined total</th>
    </tr>
    <tr>
       <td>Mints:</td>
       <td>2</td>
       <td>5</td> 
       <td>$<?php echo combined_total(2, 5); ?></td>
    </tr>
    <tr>
      <td>Toffee:</td>
      <td>3</td>
      <td>5</td> 
      <td>$<?php echo combined_total(3, 5); ?></td>
    </tr>
    <tr>
      <td>Fudge:</td>
      <td>5</td>
      <td>4</td> 
      <td>$<?php echo combined_total(5, 4); ?></td>
    </tr>
  </table>
</body>
</html>