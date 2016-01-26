<?php include('../includes/db_config.php');
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
include '../includes/header.php';


 function get_category($dbHost) {
    $sql = "SELECT category_id, category_name FROM category";
    $statement = $dbHost->prepare($sql);
    $statement->execute();
    return $statement;
  }
  
 function insert_article($dbHost,$title,$content,$cat_id) {
    $sql = "INSERT INTO article (title,content,date_posted,
    category_id) VALUES (:title,:content,:date,:cat_id)";
    $statement = $dbHost->prepare($sql);     
    $statement->bindParam(":title", $title);
    $statement->bindParam(":content", $content);
    $date = date("Y-m-d H:i:s");
    $statement->bindParam(":date", $date);
    $statement->bindParam(":cat_id", $cat_id);
    $statement->execute();
    return $statement->errorCode();
  }      
  
 function get_article_id($dbHost) {
    $articleid = $dbHost->lastInsertId(); 
    return $articleid;
  }

  $statement = get_category($dbHost);
 if (isset($_POST['submit'])) {
    $check = insert_article($dbHost, $_POST['Title'], 
    $_POST['Content'], $_POST['CategoryId']);
   if ($check==0) {
      $articleid=get_article_id($dbHost);
      echo "<div class='red'>Article number ". $articleid.
      " successfully created!</div>";
    }
  } else {?>
<form method="post" action="add_article.php" enctype="multipart/form-data">
<h2>Add an Article</h2><br />
  <label>Title: <input name="Title" type="text" /></label><br/> <br/>
  <label>Content: <textarea name="Content" ></textarea></label><br/> <br/>     
  <label>Category: <select name="CategoryId">
  <?php while($row = $statement->fetch()) { ?>
    <option value="<?= $row['category_id']; ?>"><?= $row['category_name']; ?></option> 
   <?php } ?> 
  </select> </label><br/> <br/>
  <button type="submit" name="submit" value="submit">Submit Article</button>
</form>
<?php } ?>