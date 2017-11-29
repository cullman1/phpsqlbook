<?php
class Customer { 
  public  $forename;
  public  $surname;
  public  $email;  
  private $password;
  public  $accounts;

  function __construct($forename, $surname, $email, $password, $accounts) { 
    $this->forename = $forename; 
    $this->surname  = $surname;
    $this->email    = $email;
    $this->password = $password; 
    $this->accounts = $accounts; 
  } 
   function getFullName() {
     $fullName = $this->forename . ' ' . $this->surname;
     return $fullName;
  }
}