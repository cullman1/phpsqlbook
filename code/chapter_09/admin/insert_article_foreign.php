<?php require_once('authenticate.php'); 
require_once('../includes/database_connection.php');

function insert_article($title,$content,$date,$category,$foreign) {
    $articleid = "0";
    $sql = "INSERT INTO article (title, content, posted, category_id, user_id) VALUES (:title, :content,  :date, :category, :foreign)";
    $statement = $GLOBALS['connection']->prepare($sql);
    $statement->bindParam(":title",$title);
    $statement->bindParam(":content",$content);
    $statement->bindParam(":date",$date);
    $statement->bindParam(":category",$category);
    $statement->bindParam(":foreign",$foreign);
    $statement->execute();
    if($statement->errorCode() == 0) {
        $articleid = $GLOBALS['connection']->lastInsertId();
    } 
    return $articleid;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id = insert_article($_POST["title"], $_POST["content"],date("Y-m-d H:i:s"), 1, $_POST["foreignKey"]);
        if ($id!=0 ) {
            echo "<span class='red'>Article successfully created!</span><br/>";
        } 
     }
     catch (PDOException $e) {
         echo "<span class='red'>User doesn't exist</span><br/>";
     } 
} else { ?>
<div id="body">
   <form method="post" action="insert_article_foreign.php">  
          <h2>Add an Article</h2><br />
          <label for="title">Title:
		    <input id="title" name="title" type="text" value="<?php if (isset($_REQUEST["ArticleTitle"])){ echo $_REQUEST["ArticleTitle"]; }?>" />
          </label>
          <label for="content">Content:&nbsp;
             <textarea name="content"></textarea>
          </label>
          <label for="foreignKey">Add foreign key user id
             <input id="foreignKey" name="foreignKey" type="text" value="" />
          </label>
          <br /> 
          <input id="SaveButton" type="submit" name="submit" Value="Submit" class="btn btn-primary" />
   </form>
 </div>
<div class="clear"></div>
<?php } ?>
<?php include '../includes/footer-editor.php' ?>
