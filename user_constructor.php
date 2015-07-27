<?php 
class User {
   private $fullName;
  private $email; 
  public $userImage;
 
function __construct($fullName,  $email) {
        $this->fullName = $fullName;
        $this->email = $email;
    }
} ?>