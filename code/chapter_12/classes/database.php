<?php
class Database{   
    private $serverName = "127.0.0.1";
    private $userName = "root";
    private $password = ""; 
    private $dbName       = "cms";
    public $connection;

    public function __construct() { 
        try {
            $this->connection = new PDO("mysql:host=$this->serverName;dbname=$this->dbName", 
                                        $this->userName, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->connection->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true); 
        }
        catch (PDOException $error) {
            echo 'Error message: ' . $error->getMessage() . '<br>';
            echo 'File name: ' . $error->getFile() . '<br>';
            echo 'Line number: ' . $error->getLine() . '<br>';
            echo 'Trace number: ' . var_dump($error->getTrace()) . '<br>';
            $date = date("Y-m-d H:i:s"); 
            $text = "\n". $date. " - Line:".$error->getLine()." - " . $error->getTrace() . " : " . 
            $error->getMessage() ." - ". $error->getFile();
            error_log($text, 3, "phpcustom.log");
        }
    }
}
?>