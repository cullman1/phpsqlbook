<?php
class Seed {
  public $name;
  private $image;

  public function getImage(){
    $image_path = 'images/';
    return $image_path . $this->image['name'];
  }

  public function getImageAlt(){
    return $this->image['alt'];
  }
  
 public function setImage($image){
    $this->image = $image;
  }
}
//Create an array to store in the property
$dill = array('name'=>'dill.jpg','alt'=>'Some dill');

//Create an instance of the new class
$seed = new Seed();

//Set the properties of the class
$seed->name = 'Dill';
$seed->setImage($dill);

//Display the properties
echo $seed->name;
echo '<img src="' . $seed->getImage() . 
'" title="' . $seed->getImageAlt() .  
     '" alt="' . $seed->getImageAlt() . '" />';
?>