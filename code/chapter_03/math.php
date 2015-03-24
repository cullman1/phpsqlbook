<?php
/*
PHP has several built-in functions for working with numbers.

Rounding numbers:
round(number, precision, mode)	round to nearest 
	Values for mode
	PHP_ROUND_HALF_UP - Default. At half way rounds number up. Rounds 1.5 to 2 and -1.5 to -2
	PHP_ROUND_HALF_DOWN - When it is half way rounds down. Rounds 1.5 to 1 and -1.5 to -1
	PHP_ROUND_HALF_EVEN - Round number to precision decimal places towards the next even value
	PHP_ROUND_HALF_ODD - Round number to precision decimal places towards the next odd value

ceil()	round up a fraction
floor()	round down a fraction
abs() 	absolute positive number of a value

decbin(number)	decimal to binary
dechex(number)	decimal to octet
decoct(number)	decimal to hexadecimal

fmod(x, y)		floating point remainder after division

is_nan(val) 	is not a number

rand(oid)
mt_rand(oid)

sin(arg)
cos(arg)
tan(arg)

min(values)		lowest value from array
max(values)		max value from array
*/

$number = 9.87654321;
echo 'Round: '           . round($number) 	 . '<br>';
echo 'Round to 1dp: '    . round($number, 1) . '<br>';
echo 'Round half up: '   . round($number, 1, PHP_ROUND_HALF_UP)   . '<br>';
echo 'Round half down: ' . round($number, 1, PHP_ROUND_HALF_DOWN) . '<br>';
echo 'Round half even: ' . round($number, 2, PHP_ROUND_HALF_EVEN) . '<br>';
echo 'Round half odd:  ' . round($number, 2, PHP_ROUND_HALF_ODD)  . '<br>';
echo 'Round up:  '       . ceil($number)     . '<br>';
echo 'Round down: '      . floor($number)    . '<br>';
echo 'Exponential: '     . pow(4,5)          . '<br>';
echo 'Square root: '     . sqrt(16)           . '<br>';
?>

<hr>

<?php
$number = 1.23456789;
echo '<h1>Rounding</h1>';
echo '<table>';
echo '<tr><th>Function:</th><th>Result</th></tr>';

echo '<tr><td>round($number)</td><td>' . round($number) . '</td></tr>';
echo '<tr><td>round($number, 1)</td><td>' . round($number, 1) . '</td></tr>';
echo '<tr><td>round($number, 1, PHP_ROUND_HALF_UP)</td><td>' . round($number, 1, PHP_ROUND_HALF_UP) . '</td></tr>';
echo '<tr><td>round($number, 1, PHP_ROUND_HALF_DOWN)</td><td>' . round($number, 1, PHP_ROUND_HALF_DOWN) . '</td></tr>';
echo '<tr><td>round($number, 2, PHP_ROUND_HALF_EVEN)</td><td>' . round($number, 2, PHP_ROUND_HALF_EVEN) . '</td></tr>';
echo '<tr><td>round($number, 2, PHP_ROUND_HALF_ODD)</td><td>' . round($number, 2, PHP_ROUND_HALF_ODD) . '</td></tr>';

echo '<tr><td>ceil($number)</td><td>' . ceil($number) . '</td></tr>';
echo '<tr><td>floor($number)</td><td>' . floor($number) . '</td></tr>';
echo '<tr><td>abs($number)</td><td>' . abs($number) . '</td></tr>';

echo '</table>';

echo '<h1>Random numbers</h1>'; // mt_ functions are supposed to be faster and remove some mathematical questions
echo '<table>';
echo '<tr><th>Function:</th><th>Result</th></tr>';
echo '<tr><td>rand()</td><td>' . rand() . '</td></tr>';
echo '<tr><td>rand(5,10)</td><td>' . rand(5,10) . '</td></tr>';
echo '<tr><td>mt_rand()</td><td>' . mt_rand() . '</td></tr>';
echo '<tr><td>mt_rand(5,10)</td><td>' . mt_rand(5,10) . '</td></tr>';
echo '<tr><td>getrandmax();</td><td>' . getrandmax() . '</td></tr>'; // the maximum positive value for a 32bit signed binary integer - max for int in many languages - why youtube had to alter Gangnam Style
echo '<tr><td>mt_getrandmax();</td><td>' . mt_getrandmax() . '</td></tr>';
echo '</table>';

echo '<h1>Math</h1>'; 
echo '<table>';
echo '<tr><td>pow(4,5);</td><td>' . pow(4,5) . '</td></tr>';
echo '<tr><td>sqrt(16);</td><td>' . pow(16) . '</td></tr>';
echo '</table>';
/*
An exponent is maths takes a number and multiplies it by itself.
4^5 = 4 x 4 x 4 x 4 4 = 1024

A square root is the opposite of squaring a number (number multipled by itself)
sqrt() finds the square root of a number
?>