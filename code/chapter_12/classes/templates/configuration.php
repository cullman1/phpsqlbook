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
        $this->serverName = "127.0.0.1";
        $this->userName = "root";
        $this->password = ""; 
        $this->databaseName = "cms";
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