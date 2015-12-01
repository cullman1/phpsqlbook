<?php
class User {
    private $fullname;
    private $emailAddress;								           
    private $user_id; 
    
    function __construct($fullName, $emailAddress) {
        $this->fullname = $fullName;
        $this->emailAddress = $emailAddress;
    }
    
    function getFullname()
    {
        return $this->fullname;
    }
    
    public function setFullname($name) {
        $this->fullname = $name;
    }
}
?>