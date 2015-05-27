<?php include '../includes/header-register.php';
require_once('../includes/db_config.php');
$sel_cat_set = $dbHost->prepare("select category_id, category_name FROM category");
$sel_cat_set->execute();
if (isset($_POST['Submit'])) {
  
     $ins_article_set->bindParam(":article_content", $_POST['ArticleContent']);
     $ins_article_set->bindParam(":date", date("Y-m-d H:i:s"));
     $ins_article_set->bindParam(":category_id", $_POST['CategoryId']);
     $ins_article_set = $dbHost->prepare("INSERT INTO article (title, content, date_posted, category_id, user_id) VALUES (:article_title, :article_content, :date , :category_id)");
     $ins_article_set->execute();
    if($ins_article_set->errorCode()!= 0) { 
        die("Insert Article Query failed ");
    } else {
        $articleid = "0";
        if(isset($_POST['article_id'])) {
            $articleid = $_POST['article_id'];
        } else {
            $articleid = $dbHost->lastInsertId();
        }
    }
} ?> 
    <h2>Add an Article</h2><br />
    <form id="galleryform" method="post" action="add-article.php" enctype="multipart/form-data">
            <label>Title: <input name="ArticleTitle" type="text" /></label>
		    <label>Content: <textarea name="ArticleContent"></textarea></label>     
            <label>Category: 
                <select name="CategoryId">
                <?php while($sel_category_row = $sel_cat_set->fetch()) { ?>
                    <option value="<?php  echo $sel_category_row['category_id']; ?>"><?php  echo $sel_category_row['category_name']; ?></option>
                <?php } ?> 
                </select> </label>
           <a class="btn" href="../featured-image.php">Add Featured Image</a>    <!-- <label>Add featured image:  <input type="file" id="document_upload" name="document_upload">//--> </label>
            <button name="submit" value="Submit" value="sent" class="btn btn-primary" style="float:left;display:block;">Submit Article</button>
    </form>
    <?php if (isset($_POST['submit'])) {
              echo "<span class='red' >Article ". $articleid."successfully created!</span><br/>";  
            }  ?>
<?php include '../includes/footer-site.php' ?>

