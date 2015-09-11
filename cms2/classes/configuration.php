<?php
class Configuration
{
    private $serverName;
    private $userName;
    private $password;
    private $databaseName;
    private $recordsPerPage;
    private $preSalt;
    private $afterSalt;
    public function __construct() {
        $this->serverName = "mysql51-036.wc1.dfw1.stabletransit.com";
        $this->userName = "387732_phpbook1";
        $this->password = "F8sk3j32j2fslsd0"; 
        $this->databaseName = "387732_phpbook1";
        $this->recordsPerPage = 10;
        $this->preSalt = "abD!y1";
        $this->afterSalt = "d!@gg3"; 
    }

   public function getServerName() {
        return $this->serverName;
    }
    public function getUserName() {
        return $this->userName;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getDatabaseName() {
        return $this->databaseName;
    }
    public function getRecordsPerPage() {
        return $this->recordsPerPage;
    }
    public function getPreSalt() {
        return $this->preSalt;
    }
    public function getAfterSalt() {
        return $this->afterSalt;
    }
}

?>