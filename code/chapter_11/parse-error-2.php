  <?php 
  ini_set('display_errors', '1');
  error_reporting(E_ALL);
  ?>
  <h1>Basket</h1>
  <?php
  echo "before username";
  $username = 'Ivy';
  $order = array['peas','carrot','leek');
 
 echo $username;
 foreach ($order as $item) {
   echo $item . '<br>';
 }