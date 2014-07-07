<?php 
/* Query SQL Server for total records data. */
$date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', date("Y-m-d H:i:s"))));
$tsql2 = "select Count(*) As TotalRecords FROM article where date_published <= '" . $date . "'" ;

$stmt2 = mysql_query($tsql2);
if(!$stmt2)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
$row2 = mysql_fetch_array($stmt2);
$totalRecords = $row2["TotalRecords"];
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
while($row = mysql_fetch_array($stmt)) 
{ 
  if (($count>= $startPage) && ($count <= $endPage))
  {   $recordsVisible++; ?>
  
    <div id="category_container" class="<?php echo $row['category_template']; ?>">
      <h3><a href="article-<?php echo $row['article_id']; ?>"><?php echo $row['title']; ?></a></h3>
      <h5><?php echo date("F j, Y, g:i a", strtotime($row['date_posted'])); ?></h5>
      <div class="box"><?php echo $row['content']; ?><br/>

      <div class="docs">
        <ol style="list-style-type:none; margin: 0 0 0 0">
         
        <?php 
 /* Total number of comments */
          $tsql5 = "select * from media_link join media on media.media_id = media_link.media_id WHERE media.article_id = ".$row['article_id'];
          $stmt5 = mysql_query($tsql5);
          if(!$stmt5)
          {  
            /* Error Message */
            die("Query failed: ". mysql_error());
          }
            while($row5 = mysql_fetch_array($stmt5))
            {
              echo "<li><img src='../assets/clip.png'/><a type='". $row5["file_type"] ."' href='../uploads/". $row5["url"] ."'>". $row5["url"] ."</a></li>";
            }
        ?>
          <li>
          </li>
        </ol>
      </div>
        <?php 
          /* Total number of comments */
          $tsql2 = "select count(*) as TotalComments FROM comments  WHERE article_id = ".$row['article_id'];
          $stmt2 = mysql_query($tsql2);
          if(!$stmt2)
          {  
            /* Error Message */
            die("Query failed: ". mysql_error());
          }
  
          /* Comments Per article */
          $tsql3 = "select comments_id, comment_repliedto_id, comment, user_name, comment_date FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$row['article_id']." Order by Comments_id desc";
          $stmt3 = mysql_query($tsql3);
          $stmt4 = mysql_query($tsql3);
          if(!$stmt3)
          {  
            /* Error Message */
            die("Query failed: ". mysql_error());
          }

          /* Add comments list */
          include('../includes/commentscontrol.php');
        ?>
      </div>
    </div>
  <?php 
  }
  $count=$count+1;
  $loopCount = $loopCount+1;
} 
if (mysql_num_rows($stmt)==0)
{
  echo "<br/><div>No articles found</div>";
}
?>