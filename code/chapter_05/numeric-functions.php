<?php
  $number = 9.87654321;
?>
<b>Round</h2>              <?php echo round($number); ?><br>
<b>Round to 1dp</h2>       <?php echo round($number, 1); ?><br>
<b>Round half up</h2>      <?php echo round($number, 1, PHP_ROUND_HALF_UP); ?><br>
<b>Round half down</h2>    <?php echo round($number, 1, PHP_ROUND_HALF_DOWN); ?><br>
<b>Round up</h2>           <?php echo ceil($number); ?><br>
<b>Round down</h2>         <?php echo floor($number); ?><br>
...
<b>Random number</h2>      <?php echo mt_rand(0, 10); ?><br>
<b>Exponential</h2>        <?php echo pow(4,5) ?><br>
<b>Square root</h2>        <?php echo sqrt(16); ?><br> 