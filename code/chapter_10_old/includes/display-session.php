<?php
if (!empty($_SESSION['last_viewed']['1'])) {
?>

<div class="recently-viewed">
  <h3>Recently Viewed</h3>
  <?php
    foreach($_SESSION['last_viewed'] as $item => $file){
      if ($item != 0) {
        echo '<a href="' . $file . '">';
        $pagename = str_replace('.php', '', $file);
        $pagename = (($pagename == 'index') ? 'home' : $pagename);
        echo $pagename . '</a><br/>';
      }
    }
  ?><br>
  <a href="clear-history.php">Clear history</a>
</div>

<?php
}
?>