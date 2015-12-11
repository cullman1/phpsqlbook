<?php include ('../includes/header-register.php'); 
error_reporting(E_ALL|E_WARNING|E_NOTICE);
ini_set('display_errors', TRUE); 
require_once('../includes/db_config.php'); 
function log_error_to_file($file,$msg,$code, $line) {
  $date = date("Y-m-d H:i:s"); 
  $text = "\n". $date. " - Line:".$line." - " .$code. " : "   . $msg ." - ". $file;
  error_log($text, 3, "phpcustom.log");
} 

function log_error_to_db($dbHost,$file,$msg,$code,$line) {
  try {
    $dbHost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $date = date("Y-m-d H:i:s");  
    $sql ="INSERT INTO error_log(file, message,code,line, date_raised) VALUES (:file,:message,:code,:line, :date)";
    $statement = $dbHost->prepare($sql);
    $statement->bindParam(":file", $file);
    $statement->bindParam(":message", $msg);
    $statement->bindParam(":code", $code);
    $statement->bindParam(":line", $line);
    $statement->bindParam(":date", $date);
    $statement->execute();
  } catch (Exception $ex) {
  echo $ex->getMessage();
    log_error_to_file($ex->getFile(),$ex->getMessage(), $ex->getCode(),$ex->getLine());              
  }
}

function file_upload($dbHost, $file) {
foreach($file['tmp_name'] as $key =>$tmp_name) {
     $type=  $file["type"][$key];
   if((( $type!= "image/jpeg") && ( $type!="image/png") && ( $type[$key]!="image/gif")) || ($file["size"][$key]>10000000)) {
      echo 'Illegal file type or size uploaded';
      log_error_to_db($dbHost,'file_upload_improved','Illegal file type or size uploaded','0','0'); 
    } else if ($file['tmp_name'][$key] == "") {
      echo 'Your image did not upload.';
    } else {
      $filename = $file['name'][$key];
     if(move_uploaded_file($file['tmp_name'][$key],"../uploads/". $filename)) {
         echo 'Your file ' . $filename. ' uploaded successfully.<br/>';
      } else {
         echo 'Your image '. $filename .' could not be saved.<br/>';
         log_error_to_db($dbHost,'file_upload_improved','The file '. $filename .' could not be saved',  '0','0'); 
      }
    }
  }
} 
if(isset($_FILES['image'])) {
  file_upload($dbHost, $_FILES['image']);
} else { ?>
<h2>Upload an Image</h2><br />
  <form method="post" action="file_upload_improved.php"  enctype="multipart/form-data">
   <label>Upload file: <input type="file" name="image[]" accept="image/jpeg, image/png, image/gif" multiple /> </label><br />
    <button type="submit" name="Submitted" value="sent">Submit</button>
  </form>
<?php } 
include '../includes/footer-site.php' ?>