<?php
include '../chapter9/firstuser.php';

$user2 = new User("Vincent Van Gogh", "Vincent@deciphered.com");
$user2->setFullname("Pablo Picasso");
echo $user2->getFullname();

?>