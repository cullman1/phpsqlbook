<?php 
require_once('../includes/database_connection.php');

function log_error_to_file($file,$msg,$code, $line) {
  $date = date("Y-m-d H:i:s"); 
  $text = "\n". $date. " - Line:".$line." - " . $code . 
          " : " . $msg ." - ". $file;
  error_log($text, 3, "phpcustom.log");
}

try {
  $query = "SELECT * FROM usesr";
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->execute();
} catch (Exception $ex) {
  log_error_to_file($ex->getFile(), $ex->getMessage(), 
                    $ex->getCode(), $ex->getLine());
  echo "Error occurred with log failure - emailed admin";
} 
?>