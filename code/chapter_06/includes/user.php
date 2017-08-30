<?php
class User { 
  public  $id;
  public  $forename;
  public  $surname;
  public  $email;
  private $password;
  public  $joined;
  public  $image;

  function __construct() { /* See code download */ }

  function getFullName(){
    return $this->forename . ' ' . $this->surname;
  }
}