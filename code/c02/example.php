<?php
  $product = 'Chocolate';
  $price   = 1.50;
  $tax     = 22;
  $flavors = array('milk', 'dark', 'white', 'caramel', 'orange');

  require 'includes/candy-header.php';
?> 

  <h1>The Candy Store</h1>
  <h2><?php echo $product; ?></h2>

  <p>Price: $ 
  <?php
    if ($tax > 0) {
      echo $price + (($price / 100 ) * $tax) . ' (including tax)';
    } else {
      echo $price;
    }
  ?>
  </p>
  
  <p>Flavors:
    <ul>
    <?php
      foreach ($flavors as $flavor) {
        echo '<li>' . $flavor . '</li>';
      }
    ?>
    </ul>
  </p>

  <p>Discounts for multiple packets:</h2>
  <?php 
  for ($i = 10; $i <= 50; $i = $i + 10) {
    $cost     = $i * $price;
    $discount = ($cost / 10);
    echo '<p>' . $i . ' packs: ';
    echo '$' . ($cost - $discount) . '</p>';
  }
?>

<?php include 'includes/candy-footer.php' ?>