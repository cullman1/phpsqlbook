<?php 
 class Seed {
  
  public $name;
  public $price;
  public $stock;

  function __construct() {
    $this->name = 'Basil'; 
    $this->price = '3.00';
    $this->stock = '32';
  }
}
  $seed   = new Seed();
 
  echo $seed->name . '<br>';
  echo '$' .$seed->price . '<br>';
  echo $seed->stock . ' packets';
?>