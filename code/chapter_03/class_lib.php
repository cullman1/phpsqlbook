<?php

class Seed {
  public $name;
  public $price;
  public $stock;

  public function setStock($quantity) {
    $current_stock = $this->stock;
    $this->stock = $current_stock + $quantity;
  }

  public function setPrice($new_price){
    $this->price = $new_price;
  }
  
  function __construct($name, $price, $stock) {
    $this->name = $name; 
    $this->price = $price;
    $this->stock = $stock;
  }
}