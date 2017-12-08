<?php
$number = 9.87654321;
?>
<h2>Round              <?php echo round($number); ?></h2><br>
<h2>Round to 1dp      <?php echo round($number, 1); ?></h2><br>
<h2>Round half up      <?php echo round($number, 1, PHP_ROUND_HALF_UP); ?></h2><br>
<h2>Round half down    <?php echo round($number, 1, PHP_ROUND_HALF_DOWN); ?></h2><br>
<h2>Round up           <?php echo ceil($number); ?></h2><br>
<h2>Round down         <?php echo floor($number); ?></h2><br>

<h2>Random number      <?php echo mt_rand(0, 10); ?></h2><br>
<h2>Exponential        <?php echo pow(4,5) ?></h2><br>
<h2>Square root        <?php echo sqrt(16); ?></h2><br>