<?php class User {
  private $fullName; 
  public $email, $userImage;
  function __construct($fullName, $email) {
    $this->fullName = $fullName;
    $this->email = $email;
  }
  function getFullName() {
    return $this->fullName;
  }
  function getEmail() {
    return $this->email;
  }
  function setEmail($email) {
    $this->email = $email;
  }
} ?>
