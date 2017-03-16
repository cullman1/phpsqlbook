<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
global $tax;
$tax = 5;

function test() {

global $tax;
      $tax = $tax +10;
      echo '<br>INSIDE ' . $tax;
      }

      echo $tax;
      test();
      echo '<br>OUT ' .$tax;
            test();
        echo '<br>OUT ' .$tax;

?>