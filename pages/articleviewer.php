<?php 
/* iterate through table of articles */ 
$loopCount = 1;     
if(mysql_num_rows($stmt)==0)
{
  echo "<div class='box2'>No article of that id has been published.</div>";
}
while($row = mysql_fetch_array($stmt)) 
{ ?>
<div>
  <h3><?php echo $row['title']; ?></h3>
  <h5><?php echo date("F j, Y, g:i a", strtotime($row['date_posted'])); ?></h5>
  <div class="box2"><?php echo $row['content']; ?><br/><br/>
    <?php 
    /* Total number of comments */
    $select_totalcomments_sql = "select count(*) as TotalComments FROM comments  WHERE article_id = ".$row['article_id'];
    $select_totalcomments_result = mysql_query($select_totalcomments_sql);
    if(!$select_totalcomments_result) {   die("Query failed: ". mysql_error()); }
  
    /* Comments Per article */
    $select_comments_sql = "select * FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$row['article_id'];
    $select_comments_result = mysql_query($select_comments_sql);
    $stmt4 = mysql_query($select_comments_sql);
    if(!$select_comments_result) {   die("Query failed: ". mysql_error()); }

    /* Add comments list */
    include('../includes/commentscontrol.php');
    ?>
  </div>
</div>
<?php 
    $loopCount = $loopCount+1;
} ?>