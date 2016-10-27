<?php 
class User {
   public $fullName;
  public $email; 
  public $userImage;
 
function __construct($fullName,  $email) {
        $this->fullName = $fullName;
        $this->email = $email;
    }
} ?>