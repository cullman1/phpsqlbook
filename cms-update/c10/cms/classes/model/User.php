<?php

/**
 * User short summary.
 *
 * User description.
 *
 * @version 1.0
 * @author ChrisU
 */
class User {
    public  $user_id;
    public  $forename;
    public  $surname;
    public  $email;
    private $password;
    public  $joined;
    public  $image;

     public function __construct($user_id = NULL, $forename = NULL, $surname = NULL, $email = NULL, $password = NULL, $role = NULL, $picture = NULL) {
    $this->user_id            = $user_id;
    $this->forename      = $forename;
    $this->surname       = $surname;
    $this->email         = $email;
    $this->password      = $password;
    $this->role          = $role;
    $this->picture = $picture;
  }

    public function getFullName(){
        return $this->forename . ' ' . $this->surname;
    }

      public function getPassword(){
    return $this->password;
  }
}
