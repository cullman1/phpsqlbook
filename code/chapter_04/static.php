<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

class Calculator {

  public function subtract($digit1, $digit2)  
  {
    return $digit1 - $digit2;
  }

  public static function static_subtract($digit1, 
  $digit2)  
  {
    return $digit1 - $digit2;
  }
}

echo "Before Object instantiation static calls";
echo "<br/>STATIC ". Calculator::static_subtract(10,1);
echo "<br/>NON STATIC ". Calculator::subtract(10,1);
echo "<br/>After Object instantiation non-static calls";
$calculator = new Calculator();
echo "<br/>NON STATIC". $calculator->subtract(10,1);
echo "<br/>STATIC". $calculator->static_subtract(10,1);
?>