<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php
  $string = 'Home sweet home';
?>

<h2>Lowercase</h2>
<p><?php echo strtolower($string);?></p>
<h2>Uppercase</h2>
<p><?php echo strtoupper($string);?></p>
<h2>Position of 'me'</h2>
<p><?php echo strpos($string, 'me'); ?></p>
<h2>From character 3</h2>
<p><?php echo substr($string, 3); ?></p>
<h2>Occurences of 'me'</h2>
<p><?php echo substr_count($string, 'me'); ?></p>
<h2>Characters</h2>
<p><?php echo strlen($string);?></p>
<h2>Words</h2>
<p><?php echo str_word_count($string);?></p>
<h2>Replace words</h2>
<p><?php echo str_ireplace('home', 'house', $string);?></p>
<h2>Reverse</h2>
<p><?php echo strrev($string); ?></p>
</body>
</html>