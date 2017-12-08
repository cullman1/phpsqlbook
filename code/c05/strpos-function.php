<?php $text = 'Home sweet home'; ?>

<h2>Lowercase</h2>
<p><?php echo strtolower($text);?></p>
<h2>Uppercase</h2>
<p><?php echo strtoupper($text);?></p>
<h2>Uppercase first letter</h2>
<p><?php echo ucwords($text);?></p>
<h2>Character count</h2>
<p><?php echo strlen($text);?></p>
<h2>Word count</h2>
<p><?php echo str_word_count($text);?></p>