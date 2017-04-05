<?php
$text = 'Home sweet home';

echo strpos($text, 'me');
echo '<br>';
echo strpos($text, 'me', 5);
echo '<br>';
$new_value = strpos($text, 'Ho');
if ($new_value) {echo 'problem';} else { echo $new_value;}

?>
