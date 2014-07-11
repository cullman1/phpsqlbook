<?php 
/* Query SQL Server for total records data. */
$date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', date("Y-m-d H:i:s"))));
$select_totalrecords_sql = "select Count(*) As TotalRecords FROM article where date_published <= '" . $date . "'" ;
$select_totalrecords_result = mysql_query($select_totalrecords_sql);
if(!$select_totalrecords_result) {  die("Query failed: ". mysql_error()); }
$select_totalrecords_row = mysql_fetch_array($select_totalrecords_result);
$totalRecords = $select_totalrecords_row["TotalRecords"];
$recordsVisible = 0;

/* Paging totals */ 
$loopCount = 1;     
$recordsPerPage = 10;
$startPage = 1;
$endPage = $recordsPerPage;
if (isset($_REQUEST["page"]))
{
  $currPage = $_REQUEST["page"];
  $startPage = ($_REQUEST["page"] * $recordsPerPage) - $recordsPerPage + 1;
  $endPage = ($_REQUEST["page"] * $recordsPerPage);
}
else
{
  $currPage=1;
}
$count=1;

/* Iterate through table of articles */ 
while($select_articles_row = mysql_fetch_array($select_articles_result)) 
{ 
  if (($count>= $startPage) && ($count <= $endPage))
  {   $recordsVisible++; ?>
  
    <div id="category_container" class="<?php echo $select_articles_row['category_template']; ?>">
      <h3><a href="article-<?php echo $select_articles_row['article_id']; ?>"><?php echo $select_articles_row['title']; ?></a></h3>
      <h5><?php echo date("F j, Y, g:i a", strtotime($select_articles_row['date_posted'])); ?></h5>
      <div class="box"><?php echo $select_articles_row['content']; ?><br/>

      <div class="docs">
        <ol style="list-style-type:none; margin: 0 0 0 0">
         
        <?php 
          /* Select Media Link */
      $select_medialink_sql = "select * from media_link join media on media.media_id = media_link.media_id WHERE media.article_id = ".$select_articles_row['article_id'];
          $select_medialink_result = mysql_query($select_medialink_sql);
          if(!$select_medialink_result) {   die("Query failed: ". mysql_error()); }
          while($select_medialink_row = mysql_fetch_array($select_medialink_result))
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
      $select_totalcomments_sql = "select count(*) as TotalComments FROM comments  WHERE article_id = ".$select_articles_row['article_id'];
          $select_totalcomments_result = mysql_query($select_totalcomments_sql);
          if(!$select_totalcomments_result) {   die("Query failed: ". mysql_error()); }
  
          /* Comments Per article */
          $select_comments_sql = "select comments_id, comment_repliedto_id, comment, user_name, comment_date FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$select_articles_row['article_id']." Order by Comments_id desc";
          $select_comments_result = mysql_query($select_comments_sql);
          $select_nestedcomments_result = mysql_query($select_comments_sql);
          if(!$select_comments_result) {  die("Query failed: ". mysql_error()); }
          
          /* Add comments list */
          include('../includes/comments-control.php');
        ?>
      </div>
    </div>
  <?php 
  }
  $count=$count+1;
  $loopCount = $loopCount+1;
} 
if (mysql_num_rows($select_articles_result)==0)
{
  echo "<br/><div>No articles found</div>";
}
?>