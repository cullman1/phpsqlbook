<?php
error_reporting(E_ALL|E_WARNING|E_NOTICE);
ini_set('display_errors', TRUE);
if ($_REQUEST["password"]=="secret") {
 echo "Showing restricted information";
}
?>