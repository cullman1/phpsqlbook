<?php
$username = filter_input(INPUT_COOKIE, 'name');
$color = filter_input(INPUT_COOKIE, 'color');
if ($color!='') {
       include("style1.php");
 }
  include 'cookie-menu.php';
?>
<div class="tk-proxima-nova" style="padding:10px;float:left;">Welcome to the home page</div>


