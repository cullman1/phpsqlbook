<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

class Vehicle {

  private $make  = 'porsche'; 
 
  private $year  = 1992;
}

$car = new Vehicle();

echo $car->year;
?>