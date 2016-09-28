<?php class Seed {
  private $name;
  private $price;
  private $stock;

  public function setStock($quantity) {
    $current_stock = $this->stock;
    $this->stock = $current_stock + $quantity;
  }
  public function setPrice($new_price){
    $this->price = $new_price;
  }
  public function getPrice(){
    return $this->price;
  }
  public function getName(){
    return $this->name;
  }
public function getStock(){
    return $this->stock;
  }
  function __construct($name, $price, $stock) {
    $this->name = $name; 
    $this->price = $price;
    $this->stock = $stock;
  }
}