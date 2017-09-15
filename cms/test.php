<?php
$url = "http://localhost/phpsqlbook/cms/print/hello";  
$root = "localhost/phpsqlbook/cms";   
echo next(explode('/', end(explode($root, $url))));
?>