<?php
  $greetings = array('Hi ', 'Howdy ', 'Hello ', 'Hola ',
                    'Welcome ', 'Ciao ');
  $greeting_key = array_rand($greetings);

  $best_sellers  = array('notebook', 'pencil', 'ink');
  $text_best_sellers = implode(', ', $best_sellers);

  $customer = array('forename' => 'Ivy',
                    'surname'  => 'Stone',
                    'email'    => 'ivy@example.org');
?>

<h1>Best Sellers</h1>
<p><?php 
  echo $greetings[$greeting_key];
  if (array_key_exists('forename', $customer)); {
    echo ' ' . $customer['forename'] . '!';
  }
?></p>

<p>Our top <?php echo count($best_sellers); ?> 
items today are: <?php echo $text_best_sellers ?></p>