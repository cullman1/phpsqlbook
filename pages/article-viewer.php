<?php 
/* iterate through table of articles */ 
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
<div id="comments_on_article" class="<?php echo $select_singlearticlefull_rows['category_template']; ?>">
  <h3><?php echo $select_singlearticlefull_rows['title']; ?></h3>
  <h5><?php echo date("F j, Y, g:i a", strtotime($select_singlearticlefull_rows['date_posted'])); ?></h5>
  <div class="box2"><?php echo $row['content']; ?><br/><br/>
    <?php 
    /* Total number of comments */
    $select_totalcomments_sql = "select count(*) as TotalComments FROM comments  WHERE article_id = ".$select_singlearticlefull_rows['article_id'];
    $select_totalcomments_result = $dbHost->prepare($select_totalcomments_sql);
    $select_totalcomments_result->execute();
    $select_totalcomments_result->setFetchMode(PDO::FETCH_ASSOC);
  
    /* Comments Per article */
    $select_comments_sql = "select * FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$select_singlearticlefull_rows['article_id'];
    $select_comments_result = $dbHost->prepare($select_comments_sql);
    $select_comments_result->execute();
    $select_nestedcomments_result = $dbHost->prepare($select_comments_sql);
    $select_nestedcomments_result->execute();
    $select_comments_result->setFetchMode(PDO::FETCH_ASSOC);
    $select_nestedcomments_result->setFetchMode(PDO::FETCH_ASSOC);

    /* Add comments list */
    include('../includes/comments-control.php');
    ?>
  </div>
</div>
<?php 
    $loopCount = $loopCount+1;
} ?>