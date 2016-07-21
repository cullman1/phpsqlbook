<?php
$username = filter_input(INPUT_COOKIE, 'name');
$color = filter_input(INPUT_COOKIE, 'color');
if ($color!='') {
       include("style.php");
 }
?>