<?php 
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    $date_parts = explode('-', '21-02-2017');
    $year = end($date_parts);
    echo $year;
?>