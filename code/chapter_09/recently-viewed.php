<?php
  if (isset($_SESSION['last_viewed'])) {
    $history = $_SESSION['last_viewed'];
    $items   = count($history);
  }
  if ($items > 1) {
?>
  <div class="recently-viewed">
    <h3>Recently Viewed</h3>
    <?php
      foreach($history as $item => $file){
        if ($item != 0) {
          echo '<a href="' . $file . '">';
          $page = str_replace('session-', '', $file);
          echo str_replace('.php', '', $page);
          echo '</a><br/>';
        }
      }
   ?>
  </div>
<?php } ?>