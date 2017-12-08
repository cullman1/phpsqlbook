<?php $text = 'Home sweet home'; ?>

<h2>Position of first match - case sensitive: 
<?php echo strpos($text, 'me');?></h2>
<h2>Position of first match - not case sensitive: 
<?php echo stripos($text, 'e', 5);?></h2>
<h2>Position of last match - case sensitive:
<?php echo strrpos($text, 'me');?></h2>
<h2>Position of last match - not case sensitive:
<?php echo strripos($text, 'Ho');?></h2>
<h2>Text after first match - case sensitive
<?php echo strstr($text, 'me');?></h2>
<h2>Text after first match - not case sensitive:
<?php echo stristr($text, 'ho');?></h2>
<h2>Text between two positions: 
<?php echo substr($text, 5, 10);?></h2>