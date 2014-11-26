<?php
class User {
    private $fullname;
    private $emailAddress;
    private $authenticated;

    function __construct($fullName, $emailAddress, $authenticated) {
        $this->fullName = $fullName;
        $this->emailAddress = $emailAddress;
        $this->authenticated = $authenticated;
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