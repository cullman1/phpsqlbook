<?php
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting article. */
$select_article_sql = "select article_id, title, content, category_name, category.category_id, full_name, date_posted, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where category.category_id = ".$_REQUEST["categoryid"]." order by article_id";
$select_article_result = $dbHost->prepare($select_article_sql);
$select_article_result->execute();
$select_article_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for total records data. */
$select_totalrecords_sql = "select Count(*) As TotalRecords FROM article";
$select_totalrecords_result = $dbHost->prepare($select_totalrecords_sql);
$select_totalrecords_result->execute();
$select_totalrecords_result->setFetchMode(PDO::FETCH_ASSOC);
$select_totalrecords_row = $select_totalrecords_result->fetch();
$totalRecords = $select_totalrecords_row["TotalRecords"];

/* Query SQL Server for category. */
$select_category_sql = "select category_name from category where category_id= ".$_REQUEST["categoryid"];
$select_category_result = $dbHost->prepare($select_category_sql);
$select_category_result->execute();
$select_category_result->setFetchMode(PDO::FETCH_ASSOC);
$select_category_row = $select_category_result->fetch();
$catName = $select_category_row["category_name"];
include '../includes/header.php' ?>
<div>Category:
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
          while($select_article_row = $select_article_result->fetch()) 
          { 
            if (($count>= $startPage) && ($count <= $endPage))
            { ?>
            <tr>
            <td><a href="edit-Article.php?article_id=<?php echo $select_article_row['article_id'];?>"><?php echo $select_article_row['title']; ?></a></td>
            <td><a href="<?php if ($select_article_row['role_id']==1) { echo 'admins.php';} else { echo 'users.php';} ?>"><?php echo $select_article_row['full_name']; ?></a></td>
            <td>Published: <?php echo $select_article_row['date_posted']; ?></td>
            <td>
            <?php 
                /* Query SQL Server for comments count. */
                $select_comments_sql = "select Count(*) As ArticleComments FROM comments where article_id=".$select_article_row['article_id'] ;
                $select_comments_result = $dbHost->prepare($select_comments_sql);
                $select_comments_result->execute();
                $select_comments_result->setFetchMode(PDO::FETCH_ASSOC);
                $select_comments_row =$select_comments_result->fetch();
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