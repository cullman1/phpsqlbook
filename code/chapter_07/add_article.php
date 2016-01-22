<?php require_once('../includes/db_config.php');

 function get_category($dbHost) {
   $sql = "select category_id, category_name FROM category";
   $statement = $dbHost->prepare($sql);
   $statement->execute();
   return $statement;
 }

 function insert_article($dbHost, $title, $content, $categoryid) {
   $sql = "INSERT INTO article (title, content, date_posted, category_id)  VALUES (:article_title, :article_content, :date, :category_id)";
   $statement = $dbHost->prepare($sql);     
   $statement->bindParam(":article_title",$title);
   $statement->bindParam(":article_content", $content);
   $date = date("Y-m-d H:i:s");
   $statement->bindParam(":date", $date);
   $statement->bindParam(":category_id", $categoryid);
   $statement->execute();
   return $statement->errorCode();
  }
       
 function get_article_id($dbHost) {
   $articleid = $dbHost->lastInsertId(); 
   echo "<div class='red'>Article number ". $articleid." successfully created!</div>";
 }

 function add_document($dbHost, $files) {
  $type = "../uploads/".$_FILES["docs"]["type"][$key];
   if (($type=="text/plain") || ($type=="application/msword") || ($type=="application/pdf") || ($type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document")){
    $folder = "../uploads/".$_FILES["docs"]["name"][$key];
   move_uploaded_file($_FILES['docs']['tmp_name'][$key], $folder);
   $sql = "INSERT INTO media(alt_text,file_name,file_type, file_path,file_size,date_uploaded) VALUES(:text, :name, :type, :path, :size, :date)";
   $statement = $dbHost->prepare($sql);
    $statement->bindParam(":text", $_FILES["docs"]["name"][$key]);
    $statement->bindParam(":name", $_FILES["docs"]["name"][$key]);
    $statement->bindParam(":type", $_FILES["docs"]["type"][$key]);
    $statement->bindParam(":path", $_FILES["docs"]["name"][$key]);
    $statement->bindParam(":size", $_FILES["docs"]["size"][$key]);
    $date = date("Y-m-d H:i:s");
    $statement->bindParam(":date", $date );
    $statement->execute();
    if($statement->errorCode() == 0) {     
     return $dbHost->lastInsertId(); 
     } else {
     return 0;
     }
   }
 
   function add_media_link($dbHost, $articleid, $newmediaid) {
   $sql = "INSERT INTO media_link (article_id,  media_id) VALUES (:article_id, :media_id)";
   $statement = $dbHost->prepare($sql);
    $statement->bindParam(":article_id", $articleid);
    $statement->bindParam(":media_id", $newmediaid);
    $statement->execute();
    } 
     
 $statement = get_category($dbHost);
 if (isset($_POST['submit'])) {
   $check = insert_article($dbHost, $_POST['ArticleTitle'], $_POST['ArticleContent'], $_POST['CategoryId']);
   if ($check==0) {
     get_article_id($dbHost);
   }
   if(isset($_FILES['docs'])) {
 foreach($_FILES['docs']['tmp_name']  as $key =>$tmp_name) {
   $id = add_document($dbHost, $files);
   if ($id!=0) {
     add_media_link($dbHost, $articleid, $newmediaid);
   }
  }
}
 } else {?>
  <form method="post" action="add_article.php" enctype="multipart/form-data">
    <h2>Add an Article</h2><br />
    <label>Title: <input name="ArticleTitle" type="text" /></label><br/><br/>
    <label>Content: <textarea name="ArticleContent" ></textarea></label> <br/><br/>
    <label>Category: 
      <select name="CategoryId">
      <?php while($row = $statement->fetch()) { ?>
        <option value="<?= $row['category_id']; ?>"><?= $row['category_name']; ?></option> 
      <?php } ?> 
      </select> 
   </label><br/><br/>
   <label>Add associated documents/pdfs: 
 <?php if (isset($_POST['docs'])) { 
   echo "../uploads/".$_POST['docs']; } ?>
  <input type="file" name="docs[]" id="docs" multiple>  
 </label><br/><br/>
  <button type="submit" name="submit" value="submit">Submit Article</button>
</form>
<? } 

}


?>