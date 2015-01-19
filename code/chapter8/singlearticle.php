<?php
include ('header-content.php');
require_once ('../includes/db_config.php');
$new = array();
$id = 1;
/* Query SQL Server for selecting data. */
$select_singlearticle_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=".$_REQUEST["article_id"];
$select_singlearticle_result = $dbHost->prepare($select_singlearticle_sql);
$select_singlearticle_result->execute();
$select_singlearticle_result->setFetchMode(PDO::FETCH_ASSOC);

$select_singlearticleduplicate_result = $dbHost->prepare($select_singlearticle_sql);
$select_singlearticleduplicate_result->execute();
$select_singlearticleduplicate_result->setFetchMode(PDO::FETCH_ASSOC);

$select_singlearticlefull_result = $dbHost->prepare($select_singlearticle_sql);
$select_singlearticlefull_result->execute();
$select_singlearticlefull_result->setFetchMode(PDO::FETCH_ASSOC);
$loopCount = 1;  
$currPage=1;

$select_count_rows = $select_singlearticleduplicate_result->fetchAll();
$num_rows = count($select_count_rows);
if($num_rows==0)
{
    echo "<div class='box2'>No article of that id has been published.</div>";
}
while($select_singlearticlefull_rows = $select_singlearticlefull_result->fetch()) 
{  ?>
<div id="comments_on_article" style="margin-top:150px;" class="<?php echo $select_singlearticlefull_rows['category_template']; ?>">
  <h3><?php echo $select_singlearticlefull_rows['title']; ?></h3>
  <h5><?php echo date("F j, Y, g:i a", strtotime($select_singlearticlefull_rows['date_posted'])); ?></h5>
  <div class="box2"><?php echo $select_singlearticlefull_rows['content']; ?><br/><br/>
  </div>
</div>
<?php 
    $loopCount = $loopCount+1;
} 
include 'footer.php';?>
