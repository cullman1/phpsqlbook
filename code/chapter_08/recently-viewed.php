<?php 
if (isset($_SESSION['last_viewed'])) {
  $history = $_SESSION['last_viewed'];
  $items = count($history);
  }
  if ($items>1) {
  ?>
    <div class="recently-viewed">
  <h3>Recently Viewed</h3>
<?php  
  foreach($history as $item => $filename)  {
      if ($item!=0) {
        echo '<a href="'.$filename.'" >';
        echo str_replace('.php','', $filename); 
        echo "</a><br/>";
      }
  } 
?>
</div>
<?php   } ?>