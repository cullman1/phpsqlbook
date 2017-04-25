<?php
session_start();
$_SESSION["hello"] = "";
echo "Hello" . $_SESSION["hello"];
if (!empty($_SERVER['HTTP_REFERER'])) {
echo "YES";
$file = basename($_SERVER['HTTP_REFERER']);
} else {
$file = "";
}
if (!isset($_SESSION['last_viewed'])) {
  $history = array($file);
  $_SESSION['last_viewed'] = $history;
} else {
  $history = $_SESSION['last_viewed'];
  array_unshift($history, $file);
  $history = array_unique($history);
  $_SESSION['last_viewed'] = $history;
}
?>



<div class="recently-viewed">
  <h3>Recently Viewed</h3>
  <?php
    foreach($history as $item => $file){
        echo '<a href="' . $file . '">';
        $pagename = str_replace('session-', '', $file);
        echo str_replace('.php', '', $pagename);
        echo '</a><br/>';
    }
 ?>
</div>

