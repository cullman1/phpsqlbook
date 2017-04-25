<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php
  $greetings = array('Hi ', 'Howdy ', 'Hello ', 'Hola ',
                    'Welcome ', 'Ciao ');
  $greeting  = array_rand($greetings);

  $best_sellers = array('notebook', 'pencil', 'ink');
  $text_best_sellers = implode(', ', $best_sellers);

  $customer = array('forename' => 'Ivy',
                    'surname'  => 'Stone',
                    'email'    => 'ivy@example.org');
?>

<h1>Best Sellers</h1>
<?php 
  echo $greetings[$greeting];
  if (array_key_exists('forename', $customer)); {
    echo ' ' . $customer['forename'] . '!';
  }
?>
<br><br>

Our top <?php echo count($best_sellers); ?> 
items today are: <?php echo $text_best_sellers ?><br />
</body>
</html>