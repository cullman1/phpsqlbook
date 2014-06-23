<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$tsql = "select article_id, title, content, category_name, user_name, date_posted, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=".$_REQUEST["articleid"];
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

/* iterate through table of articles */ 
$loopCount = 1;     
while($row = mysql_fetch_array($stmt)) 
{ ?>
<div>
  <h3><?php echo $row['title']; ?></h3>
  <h5><?php echo date("F j, Y, g:i a", strtotime($row['date_posted'])); ?></h5>
  <div class="box2"><?php echo $row['content']; ?><br/><br/>
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
    $tsql3 = "select * FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$row['article_id'];
    $stmt3 = mysql_query($tsql3);
    if(!$stmt3)
    {  
      /* Error Message */
      die("Query failed: ". mysql_error());
    }
    ?>
  
    <?php  
    /* comments accordion */
    while($row2 = mysql_fetch_array($stmt2)) 
    { ?>
    <div class="accordion" id="accordion2">
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $loopCount; ?>">
            <img src="../assets/comments-xl.png"/> <?php echo $row2['TotalComments']; if ($row2['TotalComments']==1) {
              echo " comment";
            }
            else
            {
              echo " comments";
            }
            ?>
          </a>
        </div>
        <div id='collapse<?php echo $loopCount; ?>' class='accordion-body collapse <?php  if (isset($_REQUEST["showcomments"])) { if ($row["article_id"] == $_REQUEST["showcomments"]) { echo "in"; }}?>'>
          <div class="accordion-inner">
            <?php if (mysql_num_rows($stmt3)!=0) 
            { ?>
            <div><b>All comments</b>  <hr/></div> 
            <?php 
            } 
            while($row3 = mysql_fetch_array($stmt3)) 
            { ?>
            <div>
              <?php echo $row3['comment'];  ?> <br/> 
              <span class='small_name'><i> <?php echo $row3['user_name'];  ?></i></span> - <span class='small_name'> <?php echo $row3['comment_date'];  ?></span>
              <hr/>
            </div>
            <?php 
            } ?>
            <div>
              <a href='addcomment.php?articleid=<?php echo $row["article_id"]; ?>'>Add a comment</a>
            </div>
          </div>
        </div>
        <?php  if (isset($_REQUEST["showcomments"])) { 
          if($_REQUEST["showcomments"] ==  $row["article_id"]) { ?>
        <form id="form1" method="post" action="addcommenttext.php">
          <div>
            <label for="commentText" >Comment:</label>
            <textarea id="commentText" name="commentText"  class="collapsearea"  style="vertical-align:top; width: 400px; height: 80px;"></textarea>
            <button type="submit" class="btn btn-default">Submit Comment</button>
            <input id='articleid' name='articleid' type='hidden' value='<?php echo $row["article_id"]; ?>'/>
          </div>
        </form>
        <?php  } 
            } ?>
      </div> 
    </div>
    <?php 
 
    } ?>
  </div>
</div>
<?php 
    $loopCount = $loopCount+1;
} ?>