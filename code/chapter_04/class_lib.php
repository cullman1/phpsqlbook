<?php
class User {
  public $name;
  private $image;
  public $accountNumber;

  function __construct($name, $image, $number) { 
    $this->name = $name;
    $this->image = $image;
    $this->accountNumber = $number; 
  }

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

class Account {
  public $name;
  public $number;
  protected $balance;

  function __construct($name, $number, $balance) { 
    $this->name = $name;
    $this->number = $number;
    $this->balance = $balance; 
  }

  public static function staticInterest($sum, $rate) {
    return $sum * $rate;
  }
  public function calcInterest($rate) {
    return $this->balance * $rate;
  }
  
   public function getBalance(){
    return $this->balance;
  }
}

class SavingsAccount extends Account {
  public static $fee;

  public function getBalance(){
    return $this->balance - self::$fee;
  }
}
?>