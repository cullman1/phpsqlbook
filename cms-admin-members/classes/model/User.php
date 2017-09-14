<?php
class User
{
  public  $id;
  public  $forename;
  public  $surname;
  public  $email;
  private $password;
  public  $joined;
  public  $role;

  public function __construct($id = NULL, $forename = NULL, $surname = NULL, $email = NULL, $password = NULL, $role = NULL) {
    $this->id       = $id;
    $this->forename = $forename;
    $this->surname  = $surname;
    $this->email    = $email;
    $this->password = $password;
    $this->role     = $role;
  }

  public function getFullName(){
    return $this->forename . ' ' . $this->surname;
  }

  public function getPassword(){
    return $this->password;
  }
}