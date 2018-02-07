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

    public function getFullName(){
        return $this->forename . ' ' . $this->surname;
    }
}
