<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

try {
	$total = 10;
    $divisor = 0;
    $calculation = $total/$divisor;
}
catch (Exception $e) {
    echo $e->message();
    
}

?>