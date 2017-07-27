<?php 
  ini_set('display_errors', '1');
  error_reporting(E_ALL);
require_once('../../cms/includes/database-connection.php');

function log_error_to_file($file,$msg,$code, $line) {
  $date = date("Y-m-d H:i:s"); 
  $text = "\n". $date. " - Line:".$line." - " . $code . 
          " : " . $msg ." - ". $file;
          $errorPath = ini_get('error_log');
          echo $errorPath;
  error_log($text, 3, "C:\\xampp\php\logs\customer111.log");
}

try {
  $query = "SELECT * FROM usersdf";
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->execute();
} catch (Exception $ex) {
  log_error_to_file($ex->getFile(), $ex->getMessage(), 
                    $ex->getCode(), $ex->getLine());
  echo "Error occurred with log failure - emailed admin";
} 
?>