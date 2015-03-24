<?php

$number = 1234.56;

setlocale(LC_MONETARY, 'en_US');
echo money_format('%i', $number) . "<br>";
echo money_format('%=*8+#4.2n', $number) . "<br>";

setlocale(LC_MONETARY, 'it_IT');
echo money_format('%.2n', $number) . "<br>";

setlocale(LC_MONETARY, 'en_US');
echo money_format('%(#10n', $number) . "<br>";
// ($        1,234.57)

//money_format() - to format as $
//number_format() - with grouped thousands

?>