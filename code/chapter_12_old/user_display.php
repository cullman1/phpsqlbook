<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require 'classes/user_constructor.php';

$user1 = new User("Morton Walsh", "morton@deciphered.com");
$user2 = new User("Bernie Day", "bernie@deciphered.com");
$user1->userImage = "../../uploads/user.jpg";
echo $user1->fullName."<br/>";
echo $user1->email."<br/>";
echo "<img width=100 src='".$user1->userImage."' />";
echo "<br/>".$user2->fullName."<br/>";
echo $user2->email."<br/>";
echo $user2->userImage; ?>