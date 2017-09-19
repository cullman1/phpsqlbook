<?php
require_once '../config.php';

include 'includes/header.php';
?>
<style>  a:link {background: none !important;} </style>
<section>
<?php

if(!extension_loaded('gd')){
  echo '<h4>gd not installed</h4>';
} else {
  echo '<h4>gd installed</h4>';
}

if (!extension_loaded('imagick')) {
  echo '<h4>imagick not installed</h4>';
} else {
  echo '<h4>imagick installed</h4>';
}

phpinfo();

?>
</section>
<?php include 'includes/footer.php'; ?>