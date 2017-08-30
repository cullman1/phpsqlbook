 <?php
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    function total($price, $quantity = 1) {
      return $price * $quantity;
    }
  ?>
  <h1>Test total()</h1>
  <code>total(3, 5)</code> returns: 
 <?php echo total(3, 5); ?><br>
 <code>total(3)</code> returns: 
 <?php echo total(3, 5); ?><br>
 <code>total()</code> returns: 
 <?php echo total(); ?><br>
