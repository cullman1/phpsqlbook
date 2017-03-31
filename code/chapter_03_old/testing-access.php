<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

class Seed {
  public  $name  = 'Basil';
  private $stock = 130;
  public static  $tax_rate  = 18;
  
  public static function getPrice($gross) {
    $tax= ($gross/100) * 18;
    return $tax;
  }
  
  public function getStockLevel() {
    return $this->stock;
  }
}

echo  Seed::$tax_rate . '%' . '<br>'; //Static property
echo  Seed::getPrice(2000) . '<br>';  //Static method
$seed = new Seed();
echo  $seed->name . '<br>';           //Public property
echo  $seed->getStockLevel() . '<br>';//Private method
?>