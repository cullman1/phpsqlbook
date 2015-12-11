<?php
require_once('../includes/db_config.php'); 
function log_error_to_file($file,$msg,$code, $line) {
  $date = date("Y-m-d H:i:s"); 
  $text = "\n". $date. " - Line:".$line." - " .$code. " : " . $msg ." - ". $file;
   error_log($text, 3, "phpcustom.log");
}

try {
  $statement = $dbHost->prepare("Select * from User"); 
  $statement->execute();
 } catch (PDOException $ex) {
    log_error_to_file($ex->getFile(),$ex->getMessage(), $ex->getCode(), $ex->getLine());
    echo "Error occurred - logged to custom error log";
 }
?>