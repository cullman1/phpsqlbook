<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

class Calculator {

  public function subtract($digit1, $digit2)  
  {
    return $digit1 - $digit2;
  }

  public static function static_subtract($digit1, $digit2)  
  {
    return $digit1 - $digit2;
  }
}

echo "STATIC". Calculator::static_subtract(10, 1);
echo "NON STATIC". Calculator::subtract(10, 1);
$calculator = new Calculator();
echo "NON STATIC". $calculator->subtract(10,1);
echo "STATIC". $calculator->static_subtract(10,1);
?>