<?php

class Account {
  public $name;
  public $number;
  private $balance;
  public static $interestRate;

  function __construct($name, $number, $balance) { 
   $this->name = $name;
   $this->number = $number;
   $this->balance = $balance; 
 }

  function deposit($amount) {
    $this->balance = $this->balance + $amount;
    return $this->balance;
  }

  function withdraw($amount){
     $this->balance = $this->balance - $amount;
     return $this->balance;
  }

  public static function calcInterest($amount, $rate) {
    
    return $amount * $thisrate;
  }

}

class User {
  public $name;
  private $image;

  public function getImage(){
    $image_path = 'images/';
    return $image_path . $this->image['name'];
  }
  public function getAlt(){
    return $this->image['alt'];
  }
  public function setImage($image){
    $this->image = $image;
  }
}
?>