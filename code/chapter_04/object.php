<?php
class User {
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
$acct = array('name'=>'ivy.jpg','alt'=>'Ivy avatar');

//Create an instance of the class
$user = new User();

//Set the properties of the class
$user->name = 'Ivy';
$user->setImage($acct);

//Display the properties
echo $user->name;
echo '<img src="' . $user->getImage() .
     '" title="' . $user->getImageAlt() .  
     '" alt="' . $user->getImageAlt() . '" />';
?>