<?php
$nav = array('Sewing'     => 'sewing.php',
             'Papercraft' => 'papercraft.php',
             'Knitting'   => 'knitting.php',
             'Art'        => 'art.php',
             'Pottery'    => 'pottery.php');
asort($nav);
$nav = array('home' => 'index.php') + $nav;

$current = $_SERVER['SCRIPT_FILENAME'];
$current = basename($current, '.php');
if ($current = 'index') {
  $current = 'home';
}
?>
<header>
  <h1>The Craft Counter</h1>
  <nav>
  <?php
    foreach($nav as $title => $link) {
      echo '<a href="' . $link . '"';
      if ($current == strtolower($title)) { 
        echo 'class="active"'; 
      }
      echo '>' . strtoupper($title) . '</a> ';
    }
  ?>
  </nav>
</header>