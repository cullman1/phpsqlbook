<?php
class Seed {
public $name;
public $price;
public $stock;
public function updateStock($quantity) {
$current_stock = $this->stock;
$this->stock = $current_stock + $quantity;
}
public function updatePrice($new_price){
$this->price = $new_price;
}
}