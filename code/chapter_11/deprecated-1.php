<?php 
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    $date = "21-02-2017";
    $contents = split('[-]', $date );
    echo $contents[2];
?>