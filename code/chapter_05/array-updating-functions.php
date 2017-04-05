<?php
  // Create array and show contents as a string
  $order = array('carrot', 'onion', 'peas');
  echo implode(', ', $order) . '<br>';
  
  array_unshift($order, 'potato');      // Add to start
  array_push($order, 'corn', 'spinach');  // and to end
  echo implode(', ', $order) . '<br>';   // Show string
  
  array_shift($order);             // Remove first item
  array_pop($order);                // Remove last item
  echo implode(', ', $order);            // Show string
?>