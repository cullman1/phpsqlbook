<?php
class User {
    private $fullname;
    private $emailAddress;
    private $authenticated;

    function __construct($fullName, $emailAddress, $authenticated)
    {
        $this->fullName = $fullName;
        $this->emailAddress = $emailAddress;
        $this->authenticated = $authenticated;
    }

    function __destruct()
    {
        if (!empty($this->authenticated))
        {
            print "Logging out";   
        }
    }
}
?>