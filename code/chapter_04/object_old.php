<?php
include("class_lib.php");
//Create an array to store in the property
$acct = array('name'=>'ivy.jpg','alt'=>'Ivy avatar');
//Create an instance of the class and set properties
$user = new User();
$user->name = 'Ivy';
$user->setImage($acct);
//Display the properties
echo $user->name;
echo '<img src="' . $user->getImage(). '" title="' . $user->getImage() .'" alt="' . $user->getAlt() . '"/>';
?>