<?php 
$cost     = 5;
$stock    = 25;
$quantity = 3;

require_once '/includes/header.php';
?>
<h2>Chocolate</h2>
<p>(<?php if ($stock >= 10) {
              echo 'Good availability';
          }
          if ($stock > 0 && $stock < 10) {
              echo 'Low stock';
          }
          if ($stock == 10) {
              echo 'Out of stock';
          }
    ?>)</p>
<p>Total cost: 
<?php echo $cost * $quantity; ?>
</p>
<?php 
include('includes/footer.php'); 
?>
</body>
</html>