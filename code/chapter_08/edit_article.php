<?php require_once('../includes/db_config.php');

 function get_article($dbHost,$articleid) {
   $sql = "SELECT * FROM article left outer join media on article.featured_media_id = media.media_id where article_id= :article_id";
   $statement = $dbHost->prepare($sql);
   $statement->bindParam(":article_id", $articleid);
   $statement->execute();
   return $statement;
 }

 function get_category($dbHost) {
   $sql = "select category_id, category_name FROM category";
   $statement = $dbHost->prepare($sql);
   $statement->execute();
   return $statement;
  }

 function update_article($dbHost,$title,$content,$cat_id,$media_id,$article_id) {
    $sql = "UPDATE article SET title= :title, featured_media_id= :media_id, content= :content, category_id= :category_id where article_id= :article_id";
    $statement = $dbHost->prepare($sql);
    $statement->bindParam(":title",$title);
    $statement->bindParam(":content", $content);
    $statement->bindParam(":category_id",$cat_id);
    $statement->bindParam(":media_id", $media_id);
    $statement->bindParam(":article_id", $article_id);
    $statement->execute();    
    return $statement->errorCode();
  }

  $article = get_article($dbHost, $_GET["id"]); 
  if (isset($_POST['submit'])) {
      $update = update_article($dbHost, $_POST['title'],$_POST['content'],$_POST['Cat_Id'],$_POST['MediaId'],$_GET['id']); 
      if($update==0) {
        echo "<span class='red'>Article ". $_GET['id']." updated.</span><br/>";
      } else {
        echo "<span class='red'>Article update failed.</span><br/>";
      }
  } else {
  while ($row = $article->fetch()) { ?> 
  <form method="post" action="edit_article.php?id=<?= $row['article_id']; ?>"enctype="multipart/form-data" >
  <h2>Edit an Article</h2><br /> 
  <label>Title: <input name="title" type="text" value="<?= $row['title']; ?>"/> 
  </label><br/><br/>
   <label>Content: <textarea name="content" cols="20" rows=10> <?= $row['content']; ?></textarea></label><br/><br/>
    <label>Category: 
     <select name="Cat_Id">
     <?php  $category = get_category($dbHost);
      while($cat_row = $category->fetch()) { ?>
        <option value="<?= $cat_row['category_id']; ?>"> <?= $cat_row['category_name']; ?></option> <?php } ?> 
     </select></label><br/><br/>
    <label>Select featured image:
     <img width=50 src="<?php if (isset($_POST['img_name'])) { 
        echo "../uploads/".$_POST['img_name']; } 
        else {  echo $row['file_path']; } ?> "/> 
      <a class="btn" href="../featured-image.php?pg=edit&id=<?= $row['article_id']; ?>">Update image</a></label>    <br/><br/>
     <button type=submit name="submit" value="submit">Submit Article</button>
    </form>
<?php } 
} ?> 