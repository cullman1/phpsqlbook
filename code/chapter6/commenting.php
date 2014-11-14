<?php include '../includes/header-site.php'; ?>
 <div class="small_box">
    <div class="small_box_top">
        CMS Articles
    </div>
    <div class="pad"><?php /* Query SQL Server for total records data. */
$date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', date("Y-m-d H:i:s"))));
/* Iterate through table of articles */ 
$loopCount = 1;   
while($row =$select_articles_result->fetch()) 
{ ?>
  
 <div id="category_container" class="<?php echo $row['category_template']; ?>">
      <h3><a href="article-<?php echo $row['article_id']; ?>"><?php echo $row['title']; ?></a></h3>
      <h5><?php echo date("F j, Y, g:i a", strtotime($row['date_posted'])); ?></h5>
      <div class="box"><?php echo $row['content']; ?><br/>

      <div class="docs">
        <ol style="list-style-type:none; margin: 0 0 0 0">
         
        <?php 
          /* Select Media Link */
      $select_medialink_sql = "select * from media_link join media on media.media_id = media_link.media_id WHERE media.article_id = ".$row['article_id'];
          $select_medialink_result = $dbHost->prepare($select_medialink_sql);
          $select_medialink_result->execute();
          $select_medialink_result->setFetchMode(PDO::FETCH_ASSOC);
          while($select_medialink_row = $select_medialink_result->fetch())
          {
             echo "<li><img src='../assets/clip.png'/><a type='". $select_medialink_row["file_type"] ."' href='../uploads/". $select_medialink_row["url"] ."'>". $select_medialink_row["url"] ."</a></li>";
          }
        ?>
          <li>
          </li>
        </ol>
      </div>
        <?php 
          /* Total number of comments */
          $select_totalcomments_sql = "select count(*) as TotalComments FROM comments  WHERE article_id = ".$row['article_id'];
          $select_totalcomments_result = $dbHost->prepare($select_totalcomments_sql);
          $select_totalcomments_result->execute();
          $select_totalcomments_result->setFetchMode(PDO::FETCH_ASSOC);
  
          /* Comments Per article */
          $select_comments_sql = "select comments_id, comment_repliedto_id, comment, full_name, comment_date FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$row['article_id']." Order by Comments_id desc";
          $select_comments_result = $dbHost->prepare($select_comments_sql);
          $select_comments_result->execute();
          $select_nestedcomments_result = $dbHost->prepare($select_comments_sql);
          $select_nestedcomments_result->execute();
          # setting the fetch mode
          $select_comments_result->setFetchMode(PDO::FETCH_ASSOC);
          $select_nestedcomments_result->setFetchMode(PDO::FETCH_ASSOC);
          /* Add comments list */
          include('../includes/comments-control.php');
        ?>
      </div>
    </div> <?
    $loopCount = $loopCount+1;
} 
$select_articles_rows = $select_articles_result->fetchAll();
$num_rows = count($select_articles_rows);
if ($num_rows==0)
{
  echo "<br/><div>No articles found</div>";
}?>
</div>
 </div>

<?php include '../includes/footer-site.php' ?>
