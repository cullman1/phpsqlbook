<h1>Discounts for larger orders</h1>
<?php 
 $products = array("peas","carrot","leek");
 $price = array("1.25", "1.00","2.45");
 $count = 0;
  foreach ($products as $item) { 
    for ($i = 10; $i < 100; $i = $i + 10) {
      $order = $i * $price[$count];
      $discount = ($order / 10);
      echo $item . ' : '. $i . ' packs $' . 
      ($order - $discount) . '<br>';
    }
    $count++;
  } ?>