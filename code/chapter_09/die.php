<?php
require_once('authenticate.php'); 
require_once('../includes/db_config.php');
function insert_article($dbHost,$title,$content,$catid, $userid) {
 $date = date("Y-m-d H:i:s");
 $sql = "INSERT INTO article (title,content,date_posted, category_id, user_id) VALUES (:title, :content, :date, :cat_id, :user_id)"; 
 $statement = $dbHost->prepare($sql);
 $statement->bindParam(":title", $title);
 $statement->bindParam(":content", $content);
 $statement->bindParam(":date", $date);
 $statement->bindParam(":cat_id", $catid);
 $statement->bindParam(":user_id", $userid);
 $statement->execute();
 if($statement->errorCode() != 0) {  
   die("Insert Article Query failed "); 
 } else {
   $newarticleid = $dbHost->lastInsertId();
   insert_media($dbHost, $newarticleid);
}
}

function insert_media($dbHost, $articleid) {
  $sql="INSERT INTO media (file_name,file_type,file_path,user_id,date_uploaded, media_title) VALUES 
  ('morton.jpg','image/jpeg',:userid,'morton.jpg','".date('Y-m-d H:i:s')."', 'Selfie')";
  $statement = $dbHost->prepare($sql);      
  $statement->bindParam(":userid",$last_id);
 $statement->execute();
}

?>