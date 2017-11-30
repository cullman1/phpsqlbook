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

     public function getPassword(){
    return $this->password;
  }
}
