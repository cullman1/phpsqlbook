<?php 
ini_set('display_errors', '1');

function my_exception_handler($exception) {
  echo "Custom message : " . $exception->getMessage();
}
   
   set_exception_handler('my_exception_handler');
    throw new Exception("This is a custom error");

    set_exception_handler();

throw new Exception("This is another custom error");

?>