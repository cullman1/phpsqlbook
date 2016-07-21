<div class="recently-viewed">
  <h3>Recently Viewed</h3>
  <?php if (isset($_SESSION["last_viewed"])) {
  echo "8";
    $reverse = array_reverse($_SESSION["last_viewed"]);
    $i=1;
    foreach($reverse as $viewed)  {
      echo "9";
      if ($i!=1) {
        echo(str_replace('.php','', $viewed)) . "<br/>";
      }
      $i++;
    }
    if ($i==2) {
      echo "None";
    } 
  } 
?>
</div>