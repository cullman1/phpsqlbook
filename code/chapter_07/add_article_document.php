<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

include '../includes/header.php';
require_once('../includes/db_config.php');
$sel_cat_set = $dbHost->prepare("select category_id, category_name FROM category");
$sel_cat_set->execute();


 if (isset($_POST['submit'])) {
    
  
  $ins_article_set = $dbHost->prepare("INSERT INTO article (title, content, date_posted, category_id, featured_media_id) VALUES (:article_title, :article_content, :date , :category_id, :media_id)"); 
  $ins_article_set->bindParam(":article_title", $_POST['ArticleTitle']);
  $ins_article_set->bindParam(":article_content", $_POST['Content']);
  $date = date("Y-m-d H:i:s");
  $ins_article_set->bindParam(":date", $date);
  $ins_article_set->bindParam(":category_id", $_POST['CategoryId']);
  $f_img="0";
  if (isset($_POST['media_id'])) {
      
      $f_img = $_POST['media_id'];
  } 
  $ins_article_set->bindParam(":media_id", $f_img);
  $ins_article_set->execute();
  $articleid = "0";
  if($ins_article_set->errorCode()!= 0) { 
    die("Insert Article Query failed ");
  } else {
    if(isset($_POST['article_id'])) {
      $articleid = $_POST['article_id'];
    } else {
      $articleid = $dbHost->lastInsertId();
      echo "1";
      if(isset($_FILES['doc_upload'])) {
          echo "2";
 foreach($_FILES['doc_upload']['tmp_name']  as $key =>$tmp_name) {
    $type = $_FILES["doc_upload"]["type"][$key];
   if(($type=="text/plain") || ($type=="application/msword") || ($type=="application/pdf") 
     || ($type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document")){
    $folder = "../uploads/".$_FILES["doc_upload"]["name"][$key];
   move_uploaded_file($_FILES['doc_upload']['tmp_name'][$key], $folder);
   $ins_media_set = $dbHost->prepare("INSERT INTO media(alt_text,file_name,file_type,     file_path,file_size,date_uploaded) VALUES(:text, :name, :type, :path, :size, :date)");
    $ins_media_set->bindParam(":text", $_FILES["doc_upload"]["name"][$key]);
    $ins_media_set->bindParam(":name", $_FILES["doc_upload"]["name"][$key]);
    $ins_media_set->bindParam(":type", $_FILES["doc_upload"]["type"][$key]);
    $ins_media_set->bindParam(":path", $_FILES["doc_upload"]["name"][$key]);
    $ins_media_set->bindParam(":size", $_FILES["doc_upload"]["size"][$key]);
    $date = date("Y-m-d H:i:s");
    $ins_media_set->bindParam(":date", $date );
    $ins_media_set->execute();
    if($ins_media_set->errorCode() != 0) {  die("Insert Media Query failed: "); }
    $newmediaid = $dbHost->lastInsertId();
   $ins_medialink_set = $dbHost->prepare("INSERT INTO media_link (article_id,  media_id) VALUES (:article_id, :media_id)");
    $ins_medialink_set->bindParam(":article_id", $articleid);
    $ins_medialink_set->bindParam(":media_id", $newmediaid);
    $ins_medialink_set->execute();
    if($ins_medialink_set->errorCode() != 0) {die("Insert Media Link Query failed"); }
    }
  }
}
    }
    echo "<div class='red' style='padding-left:10px; margin-top:110px;'>Artcle number ". $articleid." successfully created!</div><br/>";  
  }

 } else { ?> 
<script type="text/Javascript">
    function assigncontent() {
        rt = document.getElementById("rich-text-container").innerHTML;
        $('#Content').val(rt);
alert($('#Content').val());
    }
</script>
<form method="post" action="add_article_document.php" enctype="multipart/form-data" onsubmit="assigncontent()" style="padding-left:10px;">
    <h2>Add an Article</h2>
  <label>Title: <input name="ArticleTitle" type="text" style="width:300px"/></label>
  <label>Content: <?php include '../includes/editor.php'; ?></label>     
  <label>Category: <select name="CategoryId">
    <?php while($sel_cat_row = $sel_cat_set->fetch()) { ?>
    <option value="<?php  echo $sel_cat_row['category_id']; ?>"><?php echo $sel_cat_row['category_name']; ?></option> <?php } ?> 
    </select> </label>
     <label style="width:540px">Featured image: <?php if (isset($_POST['img_name'])) { echo "<img src='../uploads/".$_POST['img_name']."'/><input type='hidden' name='media_id' value='".$_POST['img_id']."' />";} ?>
         <a class="btn" href="../chapter_07/featured-image2.php?featured=add">Add featured image</a> </label>
    <label>Add associated documents/pdfs:  <?php if (isset($_POST['doc_upload'])) { 
  echo "../uploads/".$_POST['doc_upload']; } ?>   <input type="file" name="doc_upload[]" id="doc_upload" multiple />  </label>
  <button type=submit name="submit" value="sent">Submit Article</button>
    <input id="Content" name="Content" type="hidden" />

</form>
<?php }  ?>
<?php include '../includes/footer-editor.php' ?>