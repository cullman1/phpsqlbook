<?php
class User {
    private $fullName;
    private $emailAddress;
    private $authenticated;
    private $role;

    function __construct($fullName, $emailAddress, $authenticated) {
        $this->fullName = $fullName;
        $this->emailAddress = $emailAddress;
        $this->authenticated = $authenticated;
        $this->role = $role;
    }
    
    public function getFullName() {
        return $this->fullName;
    }
    
    public function getEmailAddress() {
        return $this->emailAddress;
    }
    
    public function getAuthenticated() {
        return $this->authenticated;
    }
    function getRole() {
        return $this->role;
    }

    public function setFullName($name) {
        $this->fullName = $name;
    }
    
    public function setEmailAddress($email) {
        $this->emailAddress = $email;
    }
    
    public function setAuthenticated($authenticate) {
        $this->authenticated = $authenticate;
    }
}
?>