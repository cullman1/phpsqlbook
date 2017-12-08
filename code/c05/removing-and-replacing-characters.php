<?php $text = ' Home sweet home '; ?>

<h2>Remove space from the left of the string</h2>
<p><?php echo ltrim($text);?></p>
<h2>Remove string home and space from the right</h2>
<p><?php echo rtrim($text, 'home ');?></p>
<h2>Remove spaces from both ends</h2>
<p><?php echo trim($text);?></p>
<h2>Replace the letters 'me' with 'use'</h2>
<p><?php echo str_replace('me', 'use', $text);?></p>
<h2>Replace letters 'Ho' with 'Ro'</h2>
<p><?php echo str_ireplace('Ho', 'Ro', $text);?></p>
<h2>Repeat the string</h2>
<p><?php echo str_repeat($text, 2);?></p>