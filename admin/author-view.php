<?php
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$select_article_sql = "select article_id, title, content, category_name, category.category_id, full_name, user.user_id, date_posted, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where user.user_id = ".$_REQUEST["userid"]." order by article_id";
$select_article_result = $dbHost->query($select_article_sql);
# setting the fetch mode
$select_article_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for total records data. */
$select_totalrecords_sql = "select Count(*) As TotalRecords FROM article";
$select_totalrecords_result = $dbHost->query($select_totalrecords_sql);
$select_totalrecords_result->setFetchMode(PDO::FETCH_ASSOC);
$select_totalrecords_row = mysql_fetch_array($select_totalrecords_result);
$totalRecords = $select_totalrecords_row["TotalRecords"];

/* Query SQL Server for user name. */
$select_user_sql = "select full_name from user where user_id= ".$_REQUEST["userid"];
$select_user_result = $dbHost->query($select_user_sql);
# setting the fetch mode
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);
$select_user_row = mysql_fetch_array($select_user_result);
$catName = $select_user_row["full_name"];
include '../includes/header.php' ?>
<div>User:
      <button type="button" class="btn btn-default"><?php echo $catName; ?></button>
</div>
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
          while($select_article_row = mysql_fetch_array($select_article_result)) 
          { 
            if (($count>= $startPage) && ($count <= $endPage))
            { ?>
            <tr>
            <td><a href="edit-article.php?article_id=<?php echo $select_article_row['article_id'];?>"><?php echo $select_article_row['title']; ?></a></td>
            <td><a href="<?php if ($select_article_row['role_id']==1) { echo 'admins.php';} else { echo 'users.php';} ?>"><?php echo $select_article_row['full_name']; ?></a></td>
            <td>Published: <?php echo $select_article_row['date_posted']; ?></td>
            <td>
            <?php 
                /* Query SQL Server for article comments. */
                $select_comments_sql = "select Count(*) As ArticleComments FROM comments where article_id=".$select_article_row['article_id'] ;
                $select_comments_result = $dbHost->query($select_comments_sql);
                # setting the fetch mode
                $select_comments_result->setFetchMode(PDO::FETCH_ASSOC);
                $select_comments_row = mysql_fetch_array($select_comments_result);
                $totalComments = $select_comments_row["ArticleComments"];
                echo $totalComments;
            ?>
            </td>
            <td><a onclick="javascript:return confirm(&#39;Are you sure you want to delete this item 652&#39;);" id="delete1" href="delete-data.php?article_id=<?php echo $select_article_row['article_id'];?>".><span class="glyphicon glyphicon-remove"></span></a></td>
         <?php 
        }
         $count = $count+1;
       } ?>
      </tr>
   </tbody>
</table>
<?php include '../includes/footer.php' ?>