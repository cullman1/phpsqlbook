<?php
class User
{
  public  $id;
  public  $forename;
  public  $surname;
  public $email;
  private $password;
  public $role_id;
  public $joined;

  function __construct($id = NULL, $forename = NULL, $surname = NULL, $email = NULL, 
                       $password = NULL, $role_id = NULL) {
    $this->id = $id;
    $this->forename  = $forename;
    $this->surname = $surname;
    $this->email = $email;
    $this->password  = $password;
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