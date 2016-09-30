<?php class Seed {
  public $name;
  private $price;
  private $stock;
  private $image;

public function getImageThumbnail(){
   $image_path = 'images/';
   $remove_jpg = str_replace('.jpg', '', $this->image['name']);
   return $image_path . $remove_jpg . '_thumbnail.jpg';
 }

 public function getImageAlt(){
   return $this->image['alt'];
 }

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
 function __construct($name, $price, $stock, $image) {
    $this->name = $name; 
    $this->image = $image; 
    $this->price = $price;
    $this->stock = $stock;
  }
}