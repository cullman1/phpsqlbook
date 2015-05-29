<?php 
include '../includes/header-register.php';
require_once('../includes/db_config.php');
$sel_article_set = $dbHost->prepare("SELECT * FROM article left outer join media on article.featured_media_id = media.media_id where article_id= :article_id");
$sel_article_set->bindParam(":article_id", $_GET['articleid']);
$sel_article_set->execute();
$sel_cat_set = $dbHost->prepare("select category_id, category_name FROM category");
$sel_cat_set->execute();
if (isset($_POST['submit'])) { 
    $upd_article_set = $dbHost->prepare("UPDATE article SET title= :title, content= :content, category_id= :category_id, featured_media_id = :media_id where article_id= :article_id");
    $upd_article_set->bindParam(":title", $_POST['ArticleTitle']);
    $upd_article_set->bindParam(":content", $_POST['ArticleContent']);
    $upd_article_set->bindParam(":category_id", $_POST['CategoryId']);
    $upd_article_set->bindParam(":media_id", $_POST['MediaId']);
    $upd_article_set->bindParam(":article_id", $_GET['article_id']);
    $upd_article_set->execute();
    if($upd_article_set->errorCode()!=0) {  die("Update Media Query failed"); }
    else {
         echo "<span class='red' >Article ". $_POST['article_id']." updated.</span><br/>";
    }
} else { 
  while ($sel_article_row = $sel_article_set->fetch()) { ?>
    <form method="post" action="edit_article_short.php?article_id=39" enctype="multipart/form-data" style="padding-left:10px;">
      <h2>Edit an Article</h2><br />
      <label>Title: <input style="width:300px" name="ArticleTitle" type="text" value="<?php echo $sel_article_row['title']; ?>"/></label>
      <label>Content: <textarea style="width:300px" rows="4"><?php echo $sel_article_row['content']; ?></textarea></label>
      <label>Category: <select name="CategoryId" >
      <?php while($sel_cat_row = $sel_cat_set->fetch()) { ?>
        <option value="<?php echo $sel_cat_row['category_id']; ?>">
        <?php echo $sel_cat_row['category_name']; ?></option>
      <?php } ?> 
      </select></label>
      <label style="width:340px;">Select featured image: <img width=50 src="<?php if (isset($_POST['img_name'])) { echo "../uploads/".$_POST['img_name'];}  else { echo $sel_article_row['file_path']; } ?> "/> <a class="btn" href="../chapter_07/featured-image.php?featured=edit&articleid=<?php echo $sel_article_row['article_id']; ?>">Update image</a></label> 
      <button style="position:relative; left: -220px; top:370px;" type=submit name="submit" value="submit">Submit Article</button>
    </form>
 <?php } 
 }   ?>     
<?php include '../includes/footer-site.php' ?>