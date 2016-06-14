<?php require_once('../includes/db_config.php');

 function get_category($dbHost) {
   $sql = "select category_id, category_name FROM category";
   $statement = $dbHost->prepare($sql);
   $statement->execute();
   return $statement;
 }

 function insert_article($dbHost,$title,$content,$cat_id, $media_id) {
  $sql = "INSERT INTO article (title, content, date_posted, category_id, featured_media_id) VALUES (:article_title, :article_content, :date , :cat_id, :media_id)";
  $statement = $dbHost->prepare($sql);   
  $statement->bindParam(":article_title", $title);
  $statement->bindParam(":article_content", $content);
  $date = date("Y-m-d H:i:s");
  $statement->bindParam(":date", $date);
  $statement->bindParam(":cat_id", $cat_id);
  $f_img=0;
  if (isset($media_id)) {
        $f_img = $media_id;
    } 
  $statement->bindParam(":media_id", $f_img);  
  $statement->execute();
   return $statement->errorCode();
  }
       
 function get_article_id($dbHost) {
   $articleid = $dbHost->lastInsertId(); 
   echo "<div class='red'>Article number ". $articleid." successfully created!</div>";
 }
     
 $statement = get_category($dbHost);
 if (isset($_POST['submit'])) {
   $check = insert_article($dbHost, $_POST['ArticleTitle'], $_POST['ArticleContent'], $_POST['CategoryId'], $_POST["media_id"]);
   if ($check==0) {
     get_article_id($dbHost);
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
   <label>Add featured image:<?php if(isset($_POST['img_id'])) { echo"<img src='".$_POST['image']."'/>";} ?><a href="featured_image.php?featured=add">Add image</a></label>
  <button type="submit" name="submit" value="submit">Submit Article</button>
</form>
<? } ?>