<?php
  $order = array("name" => "Basil","price" => "3","stock" => "32");
  $items = count($order);

  array_pop($order); 
  print_r($order);
  if (array_key_exists("price", $order) ) {
    $total = $order['price'] * $order['stock'];
    echo 'Total stock value = $' . $total . '<br/>';
  }

  $order = implode(', ', $order);
  echo "$order ($items items) <br>";

  $order = explode(',', $order);
    array_pop($order); 
  print_r($order);
  $random = array_rand($order);
  echo "Random item: $order[$random]";
?>
