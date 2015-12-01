<?php

class User {
    private $fullname="Pablo Picasso";
    private $emailaddress="Pablo@acme.org";          
    private $user_image="Pablo.jpg";                
}

$user= new User();
$serialized_user = serialize($user);
echo ($serialized_user);
?>