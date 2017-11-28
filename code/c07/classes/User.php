<?php 
class User {
  public  $id;
  public  $forename;
  public  $surname;
  public  $email;
  private $password;
  public  $joined;
  public  $image;

  public function getFullName(){
    return $this->forename . ' ' . $this->surname;
  }
}