<?php
class User { 
  public  $id;
  public  $forename;
  public  $surname;
  public  $email;
  private $password;
  public  $joined;
  public  $image;

  function __construct($id ='', $forename = NULL, $surname = NULL,  $email = NULL,
                       $password = NULL, $joined = NULL, $image = NULL) {
    $this->id       = $id;
    $this->forename = $forename;
    $this->surname  = $surname;
    $this->email    = $email;
    $this->password = $password;
  }

  function getFullName(){
    return $this->forename . ' ' . $this->surname;
  }
}