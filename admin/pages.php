<?php
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$tsql = "select article_id, title, content, category_name, category.category_id, user_name, user.user_id, date_posted, date_published, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id order by article_id";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}


/* Query SQL Server for total records data. */
$tsql2 = "select Count(*) As TotalRecords FROM article";
$stmt2 = mysql_query($tsql2);
if(!$stmt2)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
$row2 = mysql_fetch_array($stmt2);
$totalRecords = $row2["TotalRecords"];
$recordsVisible =$totalRecords;
?>
<?php include '../includes/header.php' ?>

      <button type="button" class="btn btn-default" onclick="window.location.href='AddArticle.php';">Add article</button>

      <!-- table of articles -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Author</th>
            <th>Date Posted</th>
            <th>Date to Publish</th>
            <th>Comments</th>
            <th>Publish</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $startPage = 1;
            $endPage = $recordsPerPage;
          if (isset($_REQUEST["page"]))
          {
            $startPage = ($_REQUEST["page"] * $recordsPerPage) - $recordsPerPage + 1;
            $endPage = ($_REQUEST["page"] * $recordsPerPage);
          }
          $count=1;
          while($row = mysql_fetch_array($stmt)) { 

          if (($count>= $startPage) && ($count <= $endPage))
          { ?>
          <tr>
            <td><a href="EditArticle.php?article_id=<?php echo $row['article_id'];?>"><?php echo $row['title']; ?></a></td>
            <td><a href="category-view.php?categoryid=<?php echo $row['category_id'];?>"><?php echo $row['category_name']; ?></a></td>
            <td><a href="author-view.php?userid=<?php echo $row['user_id'];?>"><?php echo $row['user_name']; ?></a></td>
            <td><?php echo $row['date_posted']; ?></td>
            <?php if ($row['date_published']!=null)
            { ?>
              <td><?php echo $row['date_published']; ?></td>
            <?php }
            else
             { ?>
              <td>Not Published</td>
         <?php } ?>
            <td>
<?php 
/* Query SQL Server for total records data. */
$tsql3 = "select Count(*) As ArticleComments FROM comments where article_id=".$row['article_id'] ;
$stmt3 = mysql_query($tsql3);
if(!$stmt3)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
$row3 = mysql_fetch_array($stmt3);
$totalComments = $row3["ArticleComments"];
echo $totalComments;
?>

            </td>
            <td><a href="publishdata.php?articleid=<?php echo $row['article_id']; if ($row['date_published']!=null) { echo "&publish=delete";} ?>">    
            <?php if ($row['date_published']==null)
            { ?><span class="glyphicon glyphicon-plus"></span> <?php } else { ?><span class="glyphicon glyphicon-remove red"></span><?php } ?></a></td>
      
            <td><a onclick="javascript:return confirm(&#39;Are you sure you want to delete this item <?php echo $row['article_id'];?>&#39;);" id="delete1" href="deletedata.php?article_id=<?php echo $row['article_id'];?>".><span class="glyphicon glyphicon-remove red"></span></a></td>
         <?php 
        }
         $count = $count+1;
       } ?>
         </tr>
        </tbody>
      </table>

  
<?php include('../includes/pagination.php'); ?>


<?php include '../includes/footer.php' ?>