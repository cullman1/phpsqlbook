<?php 
/* Query SQL Server for total records data. */
$tsql2 = "select Count(*) As TotalRecords FROM article where date_published <= now()";
$stmt2 = mysql_query($tsql2);
if(!$stmt2)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
$row2 = mysql_fetch_array($stmt2);
$totalRecords = $row2["TotalRecords"];

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
  { ?>
    <div>
      <h3><a href="article-<?php echo $row['article_id']; ?>"><?php echo $row['title']; ?></a></h3>
      <h5><?php echo date("F j, Y, g:i a", strtotime($row['date_posted'])); ?></h5>
      <div class="box"><?php echo $row['content']; ?><br/>
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
          $tsql3 = "select * FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$row['article_id']." Order by Comments_id ASC";
          $stmt3 = mysql_query($tsql3);
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
} ?>