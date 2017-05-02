<?php
  session_start();
  error_reporting(E_ALL|E_WARNING|E_NOTICE);
ini_set('display_errors', TRUE); 
$count1 = 1;
$count2 = 2;
$count3 = 1;
  $_SESSION = $_POST;
  $number  = ( isset($_POST['number']) ? $_POST['number'] : '1234.567' );
  $round_type =  ( isset($_POST['round_type']) ? $_POST['round_type'] : 'PHP_ROUND_HALF_UP' );
  $dp =  ( isset($_POST['dp']) ? $_POST['dp'] : 2 );
  $dp1 =  ( isset($_POST['dp1']) ? $_POST['dp1'] : $_POST['dp1']=2 );
  $dp2 =  ( isset($_POST['dp2']) ? $_POST['dp2'] :  $_POST['dp2']=2 );
  $dp3 =  ( isset($_POST['dp3']) ? $_POST['dp3'] :  $_POST['dp3']=2 );
  $dp4 =  ( isset($_POST['dp4']) ? $_POST['dp4'] :  $_POST['dp4']=2 );
  $dp5 =  ( isset($_POST['dp5']) ? $_POST['dp5'] :  $_POST['dp5']=2 );
    $dp6 =  ( isset($_POST['dp6']) ? $_POST['dp6'] :  $_POST['dp6']=2 );
       $rando2 =  ( isset($_POST['rando2']) ? $_POST['rando2'] : $_POST['rando2']=100 );
  $rando1 =  ( isset($_POST['rando1']) ? $_POST['rando1'] : $_POST['rando1']=0 );
       $rando3 =  ( isset($_POST['rando3']) ? $_POST['rando3'] : $_POST['rando3']=0 );
            $rando4 =  ( isset($_POST['rando4']) ? $_POST['rando4'] : $_POST['rando4']=100 );
                   $rando5 =  ( isset($_POST['rando5']) ? $_POST['rando5'] : $_POST['rando5']=4 );
            $rando6 =  ( isset($_POST['rando6']) ? $_POST['rando6'] : $_POST['rando6']=3 );
              $rando7 =  ( isset($_POST['rando7']) ? $_POST['rando7'] : $_POST['rando7']=16 );
  $round_type1 =  ( isset($_POST['round_type1']) ? $_POST['round_type1'] : $_POST['round_type1']='PHP_ROUND_HALF_UP' );
  $round_type2 =  ( isset($_POST['round_type2']) ? $_POST['round_type2'] :  $_POST['round_type2']='PHP_ROUND_HALF_UP' );
  $round_type3 =  ( isset($_POST['round_type3']) ? $_POST['round_type3'] :  $_POST['round_type3']='PHP_ROUND_HALF_DOWN' );
  $round_type4 =  ( isset($_POST['round_type4']) ? $_POST['round_type4'] :  $_POST['round_type4']='PHP_ROUND_HALF_EVEN' );
  $round_type5 =  ( isset($_POST['round_type5']) ? $_POST['round_type5'] :  $_POST['round_type5']='PHP_ROUND_HALF_ODD' );
  
function includeRound($count1, $dp) {
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
   include "$root/phpsqlbook/code/chapter_05/includes/round.php";
   $count1 = $count1 + 1;
   return $count1;
}

  function includeType($count2, $round_type) {
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    include "$root/phpsqlbook/code/chapter_05/includes/type.php";
   $count2 = $count2 + 1;
   return $count2;
}

 function includeRandom($count3, $round_type) {
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    include "$root/phpsqlbook/code/chapter_05/includes/random.php";
   $count3 = $count3 + 1;
   return $count3;
}

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
  <form action="math-functions-all.php" method="post">
    
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
    <td class="result"><?php $dpp = 'dp'.$count1; echo round($number, $_POST[$dpp]); ?></td>
    <td><code class="php">round($number,  <?php $count1 = includeRound($count1, $_POST[$dpp]);  ?> );</code></td>
    <td>The second parameter sets the number of decimal places to round the number to.</td>
  </tr>
  <tr>
    <td class="result"><?php $dpp = 'dp'.$count1; echo round($number, $_POST[$dpp], constant('PHP_ROUND_HALF_UP')); ?></td>
    <td><code class="php">round($number,   <?php  $count1 = includeRound($count1, $_POST[$dpp]); ?> , <?php echo 'PHP_ROUND_HALF_UP' ?> );</code></td>
    <td>The third parameter sets a rounding option.<br>Round half numbers up.</td>
  </tr>
 <tr>
    <td class="result"><?php $dpp = 'dp'.$count1; echo round($number, $_POST[$dpp],  constant('PHP_ROUND_HALF_DOWN')); ?></td>
    <td><code class="php">round($number,   <?php  $count1 = includeRound($count1, $_POST[$dpp]); ?> , <?php echo 'PHP_ROUND_HALF_DOWN' ?>);</code></td>
    <td>Round half numbers down.</td>
  </tr>
  <tr>
    <td class="result"><?php $dpp = 'dp'.$count1; echo round($number, $_POST[$dpp],  constant('PHP_ROUND_HALF_EVEN')); ?></td>
    <td><code class="php">round($number,   <?php  $count1 = includeRound($count1, $_POST[$dpp]); ?> , <?php echo 'PHP_ROUND_HALF_EVEN' ?>);</code></td>
    <td>Round to nearest even number.</td>
  </tr>
  <tr>
    <td class="result"><?php $dpp = 'dp'.$count1; echo round($number, $_POST[$dpp], constant('PHP_ROUND_HALF_ODD')); ?></td>
    <td><code class="php">round($number,  <?php  $count1 = includeRound($count1, $_POST[$dpp]); ?> , <?php echo 'PHP_ROUND_HALF_ODD' ?>);</code></td>
    <td>Round to nearest odd number.</td>
  </tr>

  <tr><td colspan="3"><h2>Random numbers:</h2></td></tr>

  <tr>

    <td class="result"><?php $dpp = 'rando'.$count3; $dpt = 'rando'.($count3+1);echo mt_rand($_POST[$dpp] , $_POST[$dpt]);  ?></td>
    <td><code class="php">mt_rand(<?php $count3 = includeRandom($count3, $_POST[$dpp]);  $count3 = includeRandom($count3, $_POST[$dpt]); ?>);</code></td>
    <td>Generate random number between 0 and 100 (you can substitute min/max numbers).</td>
  </tr>
  <tr>
    <td class="result"><?php $dpp = 'rando'.$count3; $dpt = 'rando'.($count3+1);echo rand($_POST[$dpp] , $_POST[$dpt]);  ?></td>
    <td><code class="php">rand(<?php $count3 = includeRandom($count3, $_POST[$dpp]);  $count3 = includeRandom($count3, $_POST[$dpt]); ?>);</code></td>
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
    <td class="result"><?php $dpp = 'rando'.$count3; $dpt = 'rando'.($count3+1);echo pow($_POST[$dpp] , $_POST[$dpt]);  ?></td>
    <td><code class="php">pow(<?php $count3 = includeRandom($count3, $_POST[$dpp]);  $count3 = includeRandom($count3, $_POST[$dpt]); ?>);</code></td>
    <td>Exponential expression (can also use ** operator - see pXXX).</td>
  </tr>
  <tr>
    <td class="result"><?php $dpp = 'rando'.$count3; echo sqrt($_POST[$dpp]);  ?></td>
    <td><code class="php">sqrt(<?php $count3 = includeRandom($count3, $_POST[$dpp]);  ?>);</code></td>
    <td>Square root of number.</td>
  </tr>

</table>
<br/>
<br/>