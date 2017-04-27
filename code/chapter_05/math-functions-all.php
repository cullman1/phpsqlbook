<?php
  $number  = ( isset($_POST['number']) ? $_POST['number'] : '1234.567' );
  $round_type =  ( isset($_POST['round_type']) ? $_POST['round_type'] : 'PHP_ROUND_HALF_UP' );
  $dp =  ( isset($_POST['round_type']) ? $_POST['rount_type'] : 2 );
?>
<!DOCTYPE html>
<html>
<head><title>Math</title></head>
<style type="text/css">

  body, td {font-family: arial; }
  h2 {font-size: 1.2em; margin: 1em 0 0 0;}
  .php {color: #ee7153;}


  .table_syntax th,
  .table_syntax td {border-bottom: 1px dotted #999; padding: 0.2em 1em 0.2em 0;}
  .table_syntax th {border-top: 1px dotted #999; padding: 0.2em 0; text-align: left; font-size: 0.8em; color: #666; text-transform: uppercase; background-color: #efefef; min-width: 10em;}
  .table_syntax td.result {color: #666; }
  .table_syntax td.pass::after {
    content: " (pass)"; 
    color: green;
  }
  .table_syntax td.fail {color: red;}
  .table_syntax td.fail::after {
    content: "fail"; 
    color: red;
  }
  .table_syntax td.result, 
  .table_syntax td code.php {white-space: nowrap;}

</style>
<body>
  <h1>Math functions</h1>
  <form action="math-functions.php" method="post">
    
<table class="table_syntax">
  <tr>
    <th>Example</th>
    <th>Syntax</th>
    <th>Description</th>
  </tr>

  <tr>
    <td colspan="3">
      <h2>Number:</h2>
      <input type="text" name="number" value="<?=$number; ?>"><input type="submit" name="submit" value="refresh">
    </td>
  </tr>

  <tr><td colspan="3"><h2>Rounding:</h2></td></tr>

  <tr>
    <td class="result"><?php echo ceil($number); ?></td>
    <td><code class="php">ceil($number);</code></td>
    <td>Rounds a number up.</td>
  </tr>

  <tr>
    <td class="result"><?php echo floor($number); ?></td>
    <td><code class="php">floor($number);</code></td>
    <td>Rounds a number down.</td>
  </tr>

  <tr>
    <td class="result"><?php echo abs($number); ?></td>
    <td><code class="php">abs($number);</code></td>
    <td>Absolute positive number of a value.</td>
  </tr>

   <tr>
    <td class="result"><?php echo round($number); ?></td>
    <td><code class="php">round($number);</code></td>
    <td>Rounds numbers up or down, this function has two optional parameters (see below).</td>
  </tr>
  <tr>
    <td class="result"><?php echo round($number, 2); ?></td>
    <td><code class="php">round($number, 2);</code></td>
    <td>The second parameter sets the number of decimal places to round the number to.</td>
  </tr>
  <tr>
    <td class="result"><?php echo round($number, $dp, PHP_ROUND_HALF_UP); ?></td>
    <td><code class="php">round($number, 2, 
    <select name="round_type">
    	<option value="PHP_ROUND_HALF_UP">PHP_ROUND_HALF_UP</option>
    	<option value="PHP_ROUND_HALF_DOWN">PHP_ROUND_HALF_DOWN</option>
    	<option value="PHP_ROUND_HALF_EVEN">PHP_ROUND_HALF_EVEN</option>
    	<option value="PHP_ROUND_HALF_ODD">PHP_ROUND_HALF_ODD</option>
    </select>
    );</code></td>
    <td>The third parameter sets a rounding option.<br>Round half numbers up.</td>
  </tr>
  <tr>
    <td class="result"><?php echo round($number, 2, PHP_ROUND_HALF_UP); ?></td>
    <td><code class="php">round($number, 2, PHP_ROUND_HALF_UP);</code></td>
    <td>The third parameter sets a rounding option.<br>Round half numbers up.</td>
  </tr>
  <tr>
    <td class="result"><?php echo round($number, 2, PHP_ROUND_HALF_DOWN); ?></td>
    <td><code class="php">round($number, 2, PHP_ROUND_HALF_DOWN);</code></td>
    <td>Round half numbers down.</td>
  </tr>
  <tr>
    <td class="result"><?php echo round($number, 2, PHP_ROUND_HALF_EVEN); ?></td>
    <td><code class="php">round($number, 2, PHP_ROUND_HALF_EVEN);</code></td>
    <td>Round to nearest even number.</td>
  </tr>
  <tr>
    <td class="result"><?php echo round($number, 2, PHP_ROUND_HALF_ODD); ?></td>
    <td><code class="php">round($number, 2, PHP_ROUND_HALF_ODD);</code></td>
    <td>Round to nearest odd number.</td>
  </tr>

  <tr><td colspan="3"><h2>Random numbers:</h2></td></tr>

  <tr>
    <td class="result"><?php echo mt_rand(0, 100); ?></td>
    <td><code class="php">mt_rand(0, 100);</code></td>
    <td>Generate random number between 0 and 100 (you can substitute min/max numbers).</td>
  </tr>
  <tr>
    <td class="result"><?php echo rand(0, 100); ?></td>
    <td><code class="php">rand(0, 100);</code></td>
    <td>An older (not preferred) way to generates a random number between 0 and 100.</td>
  </tr>

  <tr>
    <td class="result"><?php echo mt_getrandmax(); ?></td>
    <td><code class="php">mt_getrandmax();</code></td>
    <td>Maximum random number the PHP processor can generate.</td>
  </tr>
  <tr>
    <td class="result"><?php echo getrandmax(); ?></td>
    <td><code class="php">getrandmax();</code></td>
    <td>An older (not preferred) way to get maximum random number of the PHP processor.</td>
  </tr>

  <tr><td colspan="3"><h2>Math:</h2></td></tr>

  <tr>
    <td class="result"><?php echo pow(4, 3); ?></td>
    <td><code class="php">pow(4, 3);</code></td>
    <td>Exponential expression (can also use ** operator - see pXXX).</td>
  </tr>
  <tr>
    <td class="result"><?php echo sqrt(16); ?></td>
    <td><code class="php">sqrt(16);</code></td>
    <td>Square root of number.</td>
  </tr>

</table>