<?php
include '../chapter8/user.php';

$user2 = new User("Vincent Van Gogh", "Vincent@deciphered.com");
$user2->setFullname("Pablo Picasso");
echo $user2->getFullname();

?>