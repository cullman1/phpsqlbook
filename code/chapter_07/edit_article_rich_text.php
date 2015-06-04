<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

include '../includes/header.php';
require_once('../includes/db_config.php');
$sel_cat_set = $dbHost->prepare("select category_id, category_name FROM category");
$sel_cat_set->execute();
$sel_article_set = $dbHost->prepare("SELECT * FROM article left outer join media on article.featured_media_id = media.media_id where article_id= :article_id");
$sel_article_set->bindParam(":article_id", $_GET['articleid']);
$sel_article_set->execute();
if (isset($_POST['submit'])) { 
    $upd_article_set = $dbHost->prepare("UPDATE article SET title= :title, content= :content, category_id= :category_id, featured_media_id = :media_id where article_id= :article_id");
    $upd_article_set->bindParam(":title", $_POST['title']);
    $upd_article_set->bindParam(":content", $_POST['content']);
    $upd_article_set->bindParam(":category_id", $_POST['CategoryId']);
    $upd_article_set->bindParam(":media_id", $_POST['MediaId']);
    $upd_article_set->bindParam(":article_id", $_GET['articleid']);
    $upd_article_set->execute();
    if($upd_article_set->errorCode()!=0) { 
        die("Update Media Query failed"); 
    }
    else {
        echo "<span class='red' >Article ". $_GET['articleid']." updated.</span><br/>";
    }
} else { ?>
<script type="text/Javascript">
    function assigncontent() {
        rt = document.getElementById("rich-text-container").innerHTML;
        $('#content').val(rt);
    }
</script> 
<?php  while ($sel_article_row = $sel_article_set->fetch()) { ?>
    <form method="post" action="edit_article_rich_text.php?articleid=87" enctype="multipart/form-data" style="padding-left:10px;" onsubmit="assigncontent()">
      <h2>Edit an Article</h2><br />
      <label>Title: <input style="width:300px" name="title" type="text" value="<?php echo $sel_article_row['title']; ?>"/></label>
      <label>Content: <?php include '../includes/editor.php'; ?></label>
      <label>Category: <select name="CategoryId" >
      <?php while($sel_cat_row = $sel_cat_set->fetch()) { ?>
        <option value="<?php echo $sel_cat_row['category_id']; ?>">
        <?php echo $sel_cat_row['category_name']; ?></option>
      <?php } ?> 
      </select></label>
      <label style="width:340px;">Select featured image: <img width=50 src='<?php if (isset($_POST["img_name"])) { echo "../uploads/".$_POST["img_name"];}  else { echo $sel_article_row["file_path"]; } ?> '/> <a class="btn" href="../chapter_07/featured-image.php?featured=edit&articleid=<?php echo $sel_article_row['article_id']; ?>">Update image</a></label> 
      <button type=submit name="submit" value="submit">Submit Article</button>
        <input id="content" name="content" type="hidden" />
    </form>

 <?php } 
 }   ?> 
   
<script>
    $(document).ready(function () {
        $('#rich-text-container').wysiwyg();
    });
</script>
<?php include '../includes/footer-site.php' ?>