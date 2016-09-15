

<?php 
include 'session-include.php';
include 'cookie-include.php'; 
 include 'session-menu.php'; ?>

<div class="recently-viewed">
    <h3>Recently Viewed</h3>
    <?php if (isset($_SESSION["viewed"])) {
      $reverse = array_reverse($_SESSION["viewed"]);
      $i=1;
      foreach($reverse as $viewed)  {
      if ($i!=1) {
        echo $viewed["title"] . "<br/>";
      }
      $i++;
    }
    if ($i==2) {
      echo "None";
    } 
  } 
?>
</div>