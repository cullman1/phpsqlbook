<?php
class User
{
  public  $id;
  public  $forename;
  public  $surname;
  public $email;
  private $password;
  public  $joined;
  public  $image;
  public $role_id;
  public $tasks;

  function __construct($id ='', $forename = NULL, $surname = NULL, $email = NULL, 
                       $password = NULL, $joined = NULL, $image = NULL,  $role_id = 1) {
    $this->id = $id;
    $this->forename  = $forename;
    $this->surname = $surname;
    $this->email = $image;
    $this->password  = $password;
    $this->joined  = $joined;
    $this->image = $image;
    $this->role_id  = $role_id;
  } 

  public function getFullName(){
    return $this->forename . ' ' . $this->surname;
  }

  public function getPassword() {
      return $this->password;
  }

  public function has_permission($task) {
      return in_array($task, $_SESSION['tasks']);
  }

}