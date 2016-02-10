<?php
include ('header-content.php');
require_once ('../includes/db_config.php');
$new = array();
$id = $loopCount = 1;  
$sql = "select * FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=:id";
function get_article_by_id($dbHost, $id, $sql) {
 $statement = $dbHost->prepare($sql);
 $statement->bindParam(":id",$id);
 $statement->execute();
 return $statement;
}
function check_article_id($dbHost, $id, $sqkl) {
$statement = $dbHost->prepare($sql);
$statement->bindParam(":id",$id);
$select_count_rows = $statement->fetchAll();
$num_rows = count($select_count_rows);
return $num_rows;
}
$num_rows = check_article_id($dbHost, $_GET["id"]);
if($num_rows==0){
    echo "<div class='box2'>No article of that id has been published.</div>";
} else {
  $statement = get_article_by_id($dbHost, $_GET["id"]);
}
while($row = $statement->fetch()) {  ?>
<div class="<?php echo htmlspecialchars($row['category_template']); ?>">
  <h3><?php echo htmlspecialchars($row['title']); ?></h3>
  <h5><?php echo date("F j, Y, g:i a", strtotime($row['date_posted'])); ?></h5>
  <div class="box2"><?php echo htmlspecialchars($row['content']); ?><br/><br/>
  </div>
</div>
<?php     $loopCount = $loopCount+1;
} ?>
