<?php
  $string  = ( isset($_POST['string']) ? $_POST['string'] : 'Home sweet home' );
  $start_string = substr($string, 0, 2 );
    $start_string_four = substr($string, 0, 4 );
  $end_string = substr($string, -2)
?>
<!DOCTYPE html>
<html>
<head><title>Validate</title></head>
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
  <h1>String functions</h1>
  <form action="string-functions-all.php" method="post">
    
<table class="table_syntax">
  <tr>
    <th>Example</th>
    <th>Syntax</th>
    <th>Description</th>
  </tr>

  <tr>
    <td colspan="3">
      <h2>String:</h2>
      <input type="text" name="string" value="<?=$string; ?>"><input type="submit" name="submit" value="refresh">
    </td>
  </tr>

  <tr><td colspan="3"><h2>Case:</h2></td></tr>

  <tr>
    <td class="result"><?php echo strtolower($string) ?></td>
    <td><code class="php">strtolower($string);</code></td>
    <td>Converts all characters to lowercase</td>
  </tr>

  <tr>
    <td class="result"><?php echo strtoupper($string) ?></td>
    <td><code class="php">strtoupper($string);</code></td>
    <td>Converts all characters to uppercase</td>
  </tr>

  <tr>
    <td class="result"><?php echo ucwords($string) ?></td>
    <td><code class="php">ucwords($string);</code></td>
    <td>Converts first letter of every word to uppercase</td>
  </tr>

  <tr><td colspan="3"><h2>Finding characters:</h2></td></tr>
  
  <tr>
    <td class="result"><?php echo strpos($string, $end_string) ?></td>
    <td><code class="php">strpos($string, '<?php echo $end_string; ?>');</code></td>
    <td>Position of first occurence of a substring within a string (case sensitive and zero based)</td>
  </tr>

  <tr>
    <td class="result"><?php echo strpos($string, $end_string, 5) ?></td>
    <td><code class="php">strpos($string, '<?php echo $end_string; ?>', 5);</code></td>
    <td>Position of first occurence of a substring within a string after a specified character position</td>
  </tr>

  <tr>
    <td class="result"><?php echo stripos($string, $end_string, 5) ?></td>
    <td><code class="php">stripos($string, '<?php echo $end_string; ?>', 5);</code></td>
    <td>Non-case sensitive version of strpos()</td>
  </tr>

  <tr>
    <td class="result"><?php echo strrpos($string, $end_string) ?></td>
    <td><code class="php">strrpos($string, '<?php echo $end_string; ?>');</code></td>
    <td>Position of last occurence of a string</td>
  </tr>

  <tr>
    <td class="result"><?php echo strripos($string, $end_string) ?></td>
    <td><code class="php">strripos($string, '<?php echo $end_string; ?>');</code></td>
    <td>Non-case sensitive version of strrpos()</td>
  </tr>

  <tr>
    <td class="result"><?php echo strstr($string, $start_string) ?></td>
    <td><code class="php">strstr($string, '<?php echo $start_string; ?>');</code></td>
    <td>Returns the rest of the string after the first occurrence of a string</td>
  </tr>

  <tr>
    <td class="result"><?php echo stristr($string, $start_string) ?></td>
    <td><code class="php">stristr($string, '<?php echo $start_string; ?>');</code></td>
    <td>Case insensitive version of strstr()</td>
  </tr>

   <tr>
    <td class="result"><?php echo strrchr($string, $start_string) ?></td>
    <td><code class="php">strrchr($string, '<?php echo $start_string; ?>');</code></td>
    <td>Returns the rest of the text from the last occurence of a substring</td>
  </tr>


  <tr><td colspan="3"><h2>Get parts of a string:</h2></td></tr>

  <tr>
    <td class="result"><?php echo substr($string, 3, 5) ?></td>
    <td><code class="php">substr($string, 3, 5);</code></td>
    <td>Returns characters from a start position to an end position</td>
  </tr>

  <tr>
    <td class="result"><?php echo substr($string, 3) ?></td>
    <td><code class="php">substr($string, 3);</code></td>
    <td>If end position is omitted, the remainder of string is returned</td>
  </tr>

  <tr>
    <td class="result"><?php echo substr($string, -3) ?></td>
    <td><code class="php">substr($string, -3);</code></td>
    <td>A minus symbol finds characters from the end of the string</td>
  </tr>

  <tr>
    <td class="result"><?php echo substr_count($string, 'me') ?></td>
    <td><code class="php">substr_count($string, 'me');</code></td>
    <td>Number of times a substring occurs in the string</td>
  </tr>

  <tr>
    <td class="result"><?php echo substr_count($string, 'ho', 1, 13) ?></td>
    <td><code class="php">substr_count($string, 'ho', 1, 13);</code></td>
    <td>Number or times a substring occurs between a start and end position</td>
  </tr>


  <tr><td colspan="3"><h2>Count letters and words:</h2></td></tr>

  <tr>
    <td class="result"><?php echo strlen($string) ?></td>
    <td><code class="php">strlen($string);</code></td>
    <td>Returns the number of characters in the string</td>
  </tr>

  <tr>
    <td class="result"><?php echo str_word_count($string) ?></td>
    <td><code class="php">str_word_count($string);</code></td>
    <td>Returns the number of words in the string</td>
  </tr>


  <tr><td colspan="3"><h2>Remove whitespace and other characters:</h2></td></tr>

  <tr>
    <td class="result"><?php echo ltrim($string) ?></td>
    <td><code class="php">ltrim($string);</code></td>
    <td>Remove whitespace from the left-hand side of the string</td>
  </tr>

  <tr>
    <td class="result"><?php echo ltrim($string, 'Home') ?></td>
    <td><code class="php">ltrim($string, 'Home');</code></td>
    <td>Second parameter removes additional characters if they are found at the start of the string (case-sensitive)</td>
  </tr>

  <tr>
    <td class="result"><?php echo rtrim($string) ?></td>
    <td><code class="php">rtrim($string);</code></td>
    <td>Removes whitespace from the right-hand side of the string</td>
  </tr>

    <tr>
    <td class="result"><?php echo rtrim($string, 'home') ?></td>
    <td><code class="php">rtrim($string, 'home');</code></td>
    <td>Second parameter removes additional characters if they are found at the end of the string (case-sensitive)</td>
  </tr>

  <tr>
    <td class="result"><?php echo trim($string) ?></td>
    <td><code class="php">trim($string);</code></td>
    <td>Removes whitespace from the left-and-right-hand sides of the string</td>
  </tr>

  <tr>
    <td class="result"><?php echo trim($string, 'home') ?></td>
    <td><code class="php">trim($string, 'home');</code></td>
    <td>Second parameter removes additional characters if they are found at the start or end of the string (case-sensitive)</td>
  </tr>


  <tr><td colspan="3"><h2>Replace and repeat characters:</h2></td></tr>

  <tr>
    <td class="result"><?php echo str_replace('Home', 'old', $string) ?></td>
    <td><code class="php">str_replace('Home', 'old' $string);</code></td>
    <td>Replaces one string with another (case-sensitive)</td>
  </tr>

  <tr>
    <td class="result"><?php echo str_ireplace('hOmE', 'old', $string) ?></td>
    <td><code class="php">str_ireplace('hOmE', 'old' $string);</code></td>
    <td>Replaces one string with another (case-insensitive)</td>
  </tr>

  <tr>
    <td class="result"><?php echo strrev($string) ?></td>
    <td><code class="php">strrev($string);</code></td>
    <td>Reverses the string once</td>
  </tr>

  <tr>
    <td class="result"><?php echo str_repeat($string, 2) ?></td>
    <td><code class="php">str_repeat($string, 2);</code></td>
    <td>Repeats the string a specified number of times</td>
  </tr>

</table>