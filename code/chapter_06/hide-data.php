<?php require_once('../includes/db_config.php');

function get_articles($dbHost) {
  $query = "select * FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id order by article_id limit 10";
  $statement = $dbHost->prepare($query);
  $statement->execute(); 
  return $statement;
}

function publish_remove($dbHost,$query,$articleid) {
  $statement = $dbHost->prepare($query);
  $statement->bindParam(":articleid", $articleid);
  $statement->execute();
  if($statement->errorCode()!=0) {  
    die("Delete Article Query failed"); 
  } 
}

if (isset($_GET["publish"])) {
  $query="update article set date_published = null where article_id= :articleid";
  publish_remove($dbHost,$query,$_GET["article"]); 
} else if (isset($_GET["article"])) {
  $query="update article set date_published = '". date('Y-m-d H:i:s')."' where article_id=   :articleid";
  publish_remove($dbHost,$query,$_GET["article"]); 
}
$statement = get_articles($dbHost); ?>
<?php include '../includes/header.php' ?>
<table class="table table-hover">
  <tr><th>Title</th><th>Category</th><th>Author</th><th>Date Posted</th><th>Delete</th></tr>
  <?php while($row = $statement->fetch()) {  ?>
   <tr>   
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['category_name']; ?></td>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['date_published']; ?></td>  
    <td><a href="hide-data.php?article=<?php echo $row['article_id']; 
    if ($row['date_published']!=null) { echo "&publish=delete";} ?>">    
    <?php if ($row['date_published']==null) { ?> 
      <span class="glyphicon glyphicon-plus"></span> 
    <?php } else { ?>             
      <span class="glyphicon glyphicon-remove red"></span>
    <?php } ?></a></td>
   </tr>
  <?php } ?>
</table>
<?php include '../includes/footer.php' ?>