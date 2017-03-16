<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
// Again this is optional - works with and without
static $tax;
$tax = 5;

function test() {

static $tax;
      $tax = $tax +10;
      echo '<br>INSIDE ' . $tax;
      }

      echo $tax;
      test();
      echo '<br>OUT ' .$tax;
       test();
        echo '<br> OUT ' .$tax;

?>