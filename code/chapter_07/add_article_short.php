<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

include '../includes/header-register.php';
require_once('../includes/db_config.php');
$sel_cat_set = $dbHost->prepare("select category_id, category_name FROM category");
$sel_cat_set->execute();
 if (isset($_POST['submit'])) {
  $ins_article_set = $dbHost->prepare("INSERT INTO article (title, content, date_posted, category_id) VALUES (:article_title, :article_content, :date , :category_id)");     
  $ins_article_set->bindParam(":article_title", $_POST['ArticleTitle']);
  $ins_article_set->bindParam(":article_content", $_POST['ArticleContent']);
  $date = date("Y-m-d H:i:s");
  $ins_article_set->bindParam(":date", $date);
  $ins_article_set->bindParam(":category_id", $_POST['CategoryId']);
  $ins_article_set->execute();
  $articleid = "0";
  if($ins_article_set->errorCode()!= 0) { 
        die("Insert Article Query failed ");
    } else {
       if(isset($_POST['article_id'])) {
            $articleid = $_POST['article_id'];
        } else {
            $articleid = $dbHost->lastInsertId();
        }
         echo "<div class='red' style='padding-left:10px; margin-top:10px;'>Article number ". $articleid." successfully created!</div><br/>";  
    }
} else { ?> 
<form method="post" action="add_article_short.php" enctype="multipart/form-data" style="padding-left:10px;">
    <h2>Add an Article</h2>
  <label>Title: <input name="ArticleTitle" type="text" style="width:300px"/></label>
  <label>Content: <textarea name="ArticleContent" rows="4" style="width:300px"></textarea></label>     
  <label>Category: <select name="CategoryId">
    <?php while($sel_cat_row = $sel_cat_set->fetch()) { ?>
    <option value="<?php  echo $sel_cat_row['category_id']; ?>"><?php echo $sel_cat_row['category_name']; ?></option> <?php } ?> 
    </select> </label>
  <button type=submit name="submit" value="sent" style="position:relative; left: -110px; top:300px;">Submit Article</button>
</form>
<?php }  ?>
<?php include '../includes/footer-site.php' ?>

