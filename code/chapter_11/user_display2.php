<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
include 'classes/user_accessors.php';
$user1 = new User("Morton Walsh", "morton@deciphered.com");
echo $user1->getFullName()."<br/>";
echo $user1->getEmail()."<br/>"; 
$user1->setEmail("morton@wagon.com");
echo $user1->getEmail()."<br/>";
$user1->fullName = "Morton Doofus"; ?>