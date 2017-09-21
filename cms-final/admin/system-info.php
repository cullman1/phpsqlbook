<?php
require_once '../config.php';

include 'includes/header.php';
?>
<style>  a:link {background: none !important;} </style>
<section>
<?php

if(!extension_loaded('gd')){
  echo '<div class="alert alert-danger" role="alert">gd not installed</div>';
} else {
  echo '<div class="alert alert-success" role="alert">gd installed</div>';
}

if (!extension_loaded('imagick')) {
  echo '<div class="alert alert-danger" role="alert">imagemagik not installed</div>';
} else {
  echo '<div class="alert alert-success" role="alert">imagemagik installed</div>';
}

phpinfo();

?>
</section>
<?php include 'includes/footer.php'; ?>