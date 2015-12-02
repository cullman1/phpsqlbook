<?php
require_once('authenticate.php'); 
require_once('../../includes/db_config.php');

function insert_media($dbHost, $articleid, $date, $userid) {
  $sql="INSERT INTO media (file_name,file_type,file_path,user_id,date_uploaded, media_title) VALUES ('morton.jpg','image/jpeg', :userid,'morton.jpg', :date, 'Selfie')";
  $statement = $dbHost->prepare($sql);  
  $statement->bindParam(":userid", $userid); 
  $statement->bindParam(":date", $date);   
  $statement->execute();
   if ($statement->errorCode() != 0) {  
    die("Insert Media Query failed "); 
  }
  return "Uploaded successfully";
}

function insert_article($dbHost,$title,$content,$catid, $userid, $image) {
   $catid="gdfgf";
  $date = "gdfg"; //date("Y-m-d H:i:s");
  $sql = "INSERT INTO article (title,content,date_posted, category_id, user_id) VALUES (:title, :content, :date, :cat_id, :user_id)"; 
  $statement = $dbHost->prepare($sql);
  $statement->bindParam(":title", $title);
  $statement->bindParam(":content", $content);
  $statement->bindParam(":date", $date);
  $statement->bindParam(":cat_id", $catid);
  $statement->bindParam(":user_id", $userid);
  $statement->execute();
  if ($statement->errorCode() != 0) {  
    die("Insert Article Query failed "); 
  } else {
    $msg = insert_media($dbHost, $image, $date, $userid);
  }
  return $msg;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
$msg = insert_article($dbHost,$_POST["ArticleTitle"],$_POST["ArticleContent"],"1", $_SESSION["authenticated"], $_FILES["image_upload"]);
echo $msg;
}

?>
<form method="post" action="die.php" enctype="multipart/form-data" style="padding-left:10px;">
    <h2>Add an Article</h2>
  <label>Title: <input name="ArticleTitle" type="text" style="width:300px"/></label>
  <label>Content: <textarea name="ArticleContent" rows="4" style="width:300px"></textarea></label>     
  <label>Image: 
   <input type="file" id="image_upload" name="image_upload" />  </label>
  <button type=submit name="submit" value="sent" >Submit Article</button>
</form>