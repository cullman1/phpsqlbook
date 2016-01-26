<?php require_once('../includes/db_config.php');
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
include '../includes/header.php';
 
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
   return $articleid;
 }

 function add_document($dbHost, $files, $key) {
   $type = $files["type"][$key];
   if (($type=="text/plain") || ($type=="application/msword") || ($type=="application/pdf") || ($type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document")) {
     $folder = "../uploads/".$files["name"][$key];
     echo "FOLDER". $folder;
     move_uploaded_file($files['tmp_name'][$key], $folder);
     $sql = "INSERT INTO media(alt_text,file_name,file_type, file_path,file_size,date_uploaded) VALUES(:text, :name, :type, :path, :size, :date)";
     $statement = $dbHost->prepare($sql);
     $path = "../uploads/".$files["name"][$key];
     $statement->bindParam(":text", $files["name"][$key]);
     $statement->bindParam(":name", $files["name"][$key]);
     $statement->bindParam(":type", $files["type"][$key]);
     $statement->bindParam(":path", $path);
     $statement->bindParam(":size", $files["size"][$key]);
     $date = date("Y-m-d H:i:s");
     $statement->bindParam(":date", $date );
     $statement->execute();
     if($statement->errorCode() == 0) {     
       return $dbHost->lastInsertId(); 
     } 
    } 
    return 0;
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
   $check = insert_article($dbHost, $_POST['title'], $_POST['content'], $_POST['CategoryId']);
   $articleid=0;
   if ($check==0) {
     $articleid = get_article_id($dbHost);
     echo "<div class='red'>Article number ". $articleid." successfully created!</div>";
   }
   if(!empty($_FILES['docs']['name'][0])) {
     foreach($_FILES['docs']['tmp_name']  as $key =>$tmp_name) {
     $mediaid = add_document($dbHost,$_FILES['docs'], $key);
     if ($articleid!=0) {
       add_media_link($dbHost, $articleid, $mediaid);
     }
   }
  }
 } else {?>
  <form method="post" action="add_article_editor.php" onsubmit="assigncontent()" enctype="multipart/form-data">
    <h2>Add an Article</h2><br />
    <label>Title: <input name="title" type="text" /></label><br/><br/>
    <label>Content:<?php include '../includes/editor.php'; ?></label> <br/><br/>
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
  <input id="content" name="content" type="hidden" />
 </label><br/><br/>
  <button type="submit" name="submit" value="submit">Submit Article</button>
</form>
<?php }  ?>
<script type="text/Javascript">
function assigncontent() {
rt=document.getElementById("rich-text-container").innerHTML; 
$('#content').val(rt);
}
</script>
<script>
  $(document).ready(function() {
            $('#rich-text-container').wysiwyg();
        });
</script>