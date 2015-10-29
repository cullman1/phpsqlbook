<?php require_once('../includes/db_config.php');
try {
  $dbHost->beginTransaction();
  $query="INSERT INTO user(full_name,email,date_joined,image,active) VALUES 
   ('Morton Walsh','morton@deciphered.com','morton.jpg','". date('Y-m-d H:i:s')."', 0)";
  $statement = $dbHost->prepare($query);
  $statement->execute();  
  echo "<br/>User record inserted";
  $query = "SELECT LAST_INSERT_ID()";    
  $statement = $dbHost->prepare($query);
  $statement->execute(); 
  $last_id = $dbHost->lastInsertId();
  echo "<br/>User id retrieved";
  $query="INSERT INTO media (file_name,file_type,file_path,user_id,date_uploaded, media_title) VALUES 
  ('morton.jpg','image/jpeg',:userid,'morton.jpg','".date('Y-m-d H:i:s')."', 'Selfie')";
  $statement = $dbHost->prepare($query);      
  $statement->bindParam(":userid",$last_id);
  $statement->execute();
  echo "<br/>Image added to media table";
  $dbHost->commit();
  echo "<br/>Transaction completed.";
} catch (Exception $e) {
   echo "<br/>Transaction failed, rolling back:" . $e->getMessage();       
   $dbHost->rollback();
} ?>