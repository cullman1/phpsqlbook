<?php
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$tsql = "select article_id, title, content, category_name, category.category_id, user_name, user.user_id, date_posted, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where user.user_id = ".$_REQUEST["userid"]." order by article_id";
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

/* Query SQL Server for total records data. */
$tsql3 = "select user_name from user where user_id= ".$_REQUEST["userid"];
$stmt3 = mysql_query($tsql3);
if(!$stmt3)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
$row3 = mysql_fetch_array($stmt3);
$catName = $row3["user_name"];
?>
<?php include '../includes/header.php' ?>

      <div>User:
      <button type="button" class="btn btn-default"><?php echo $catName; ?></button></div>
      <!-- table of articles -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Published</th>
            <th>Comments</th>
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
 //echo "<span>Count ".$count." Start Page ".$startPage. " End Page " .$endPage. " Records Per Page " . $recordsPerPage." </span><br/>";
          if (($count>= $startPage) && ($count <= $endPage))
          { ?>
          <tr>
            <td><a href="EditArticle.php?article_id=<?php echo $row['article_id'];?>"><?php echo $row['title']; ?></a></td>
            <td><a href="<?php if ($row['role_id']==1) { echo 'admins.php';} else { echo 'users.php';} ?>"><?php echo $row['user_name']; ?></a></td>
            <td>Published: <?php echo $row['date_posted']; ?></td>
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
            <td><a onclick="javascript:return confirm(&#39;Are you sure you want to delete this item 652&#39;);" id="delete1" href="deletedata.php?article_id=<?php echo $row['article_id'];?>".><span class="glyphicon glyphicon-remove"></span></a></td>
         <?php 
        }
         $count = $count+1;
       } ?>
         </tr>
        </tbody>
      </table>



<?php include '../includes/footer.php' ?>