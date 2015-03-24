<html>
<body>
<?php
  $string = 'Home sweet home';
?>


<?php
echo 'Lowercase: ' 			.	strtolower($string) 	. '<br>';
echo 'Uppercase: ' 			. 	strtoupper($string) 	. '<br>';
echo 'Position of first ho' .	strrchr($string, 'ho') 	. '<br>';
echo 'From swe on: ' 		.	stristr($string, 'SWE') . '<br>';
echo 'After 5th character:'	.	substr($string, 5) 		. '<br>';
echo 'Last 3 characters: ' 	.	substr($string, -3) 	. '<br>';
echo 'Characters: ' 		.	strlen($string) 		. '<br>';
echo 'Words: ' 				.	str_word_count($string) . '<br>';
echo 'Replace characters: ' .	str_replace('sweet', 'old', $string) . '<br>';
echo 'Reverse string: ' 	.	strrev($string) 		. '<br>';
echo 'Repeat string: ' 		.	str_repeat($string, 2) 	. '<br>';
?>
<hr>

<table>
	<th>Code</th><th>Result</th>
<?php
echo '<tr><td colspan="2">CASE</td></tr>';
echo '<tr><td>strtolower($string)</td><td>' 			.		strtolower($string) . '</td></tr>';
echo '<tr><td>strtoupper($string)</td><td>' 			. 		strtoupper($string) . '</td></tr>';
echo '<tr><td>ucwords($string)</td><td>' 				.		ucwords($string) . '</td></tr>';

echo '<tr><td colspan="2">FINDING CHARACTERS</td></tr>';
echo '<tr><td>strpos($string, &#39;me&#39;)	</td><td>' 	.		strpos($string, 'me') . '</td></tr>';
echo '<tr><td>strpos($string, &#39;me&#39;, 5)</td><td>' .		strpos($string, 'me', 5) . '</td></tr>';
echo '<tr><td>stripos($string, &#39;Me&#39;, 5)</td><td>' .		stripos($string, 'Me', 5) . '</td></tr>';
echo '<tr><td>strrpos($string, &#39;me&#39;)</td><td>' .		strrpos($string, 'me') . '</td></tr>';
echo '<tr><td>strripos($string, &#39;Me&#39;)</td><td>' .		strripos($string, 'Me') . '</td></tr>';
echo '<tr><td>strrchr($string, &#39;ho&#39;)</td><td>' .		strrchr($string, 'ho') . '</td></tr>';
echo '<tr><td>strstr($string, &#39;ho&#39;)	</td><td>' .		stristr($string, 'ho') . '</td></tr>';
echo '<tr><td>stristr($string, &#39;ho&#39;)</td><td>' .		stristr($string, 'ho') . '</td></tr>';

echo '<tr><td colspan="2">GET PARTS OF STRING</td></tr>';
echo '<tr><td>substr($string, 3)</td><td>'				.		substr($string, 3) . '</td></tr>';
echo '<tr><td>substr($string, 3, 5)</td><td>' 			.		substr($string, 3, 5) . '</td></tr>';
echo '<tr><td>substr($string, -3)</td><td>' 			.		substr($string, -3) . '</td></tr>';
echo '<tr><td>substr_count($string, &#39;home&#39;)</td><td>' .	substr_count($string, 'me') . '</td></tr>';
echo '<tr><td>substr_count($string, &#39;home&#39;, 5, 10)</td><td>' .				substr_count($string, 'ho', 5, 10) . '</td></tr>';
echo '<tr><td>strpbrk($string, &#39;es&#39;)</td><td>'	.		strpbrk($string, 'es') . '</td></tr>';

echo '<tr><td colspan="2">COUNT LETTERS AND WORDS</td></tr>';
echo '<tr><td>strlen($string)</td><td>' 				.		strlen($string) . '</td></tr>';
echo '<tr><td>str_word_count($string)</td><td>' 		.		str_word_count($string) . '</td></tr>';

echo '<tr><td colspan="2">REPLACE CHARACTERS</td></tr>';
echo '<tr><td>str_replace($string, &#39;home&#39;, &#39;house&#39;)</td><td>' .		str_replace('sweet', 'old', $string) . '</td></tr>';
echo '<tr><td>str_ireplace($string, &#39;home&#39;, &#39;house&#39;)</td><td>' .	str_ireplace('sWeEt', 'old', $string) . '</td></tr>';
echo '<tr><td>strrev()</td><td>' 						.			strrev($string) . '</td></tr>';
echo '<tr><td>str_repeat($string, 2)</td><td>' 			.			str_repeat($string, 2) . '</td></tr>';

?>
</table>

</body>
</html>