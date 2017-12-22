<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$rubishcharacters='[#|\[{}\]´`≠,;.:-\\_<>=*+"\'?()!§$&%в';
$searchstring='відео';

function mb_str_split( $string ) { 
    # Split at all position not after the start: ^ 
    # and not before the end: $ 
    return preg_split('/(?<!^)(?!$)/u', $string ); 
}

echo str_replace(mb_str_split($rubishcharacters), ' ', $searchstring);


?>