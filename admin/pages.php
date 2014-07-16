<?php
require_once('authenticate.php'); 

/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting articles. */
$select_articles_sql = "select article_id, title, content, category_name, category.category_id, user_name, user.user_id, date_posted, date_published, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id order by article_id";
$select_articles_result = $dbHost->query($select_articles_sql);
# setting the fetch mode
$select_articles_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for total records data. */
$select_recordcount_sql = "select Count(*) As TotalRecords FROM article";
$select_recordcount_result = $dbHost->query($select_recordcount_sql);
# setting the fetch mode
$select_recordcount_result->setFetchMode(PDO::FETCH_ASSOC);

$select_recordcount_row = mysql_fetch_array($select_recordcount_result);
$totalRecords = $select_recordcount_row["TotalRecords"];
$recordsVisible =$totalRecords;

include '../includes/header.php' ?>
      <button type="button" class="btn btn-default" onclick="window.location.href='add-article.php';">Add article</button>

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
          while($select_articles_row = mysql_fetch_array($select_articles_result)) { 

          if (($count>= $startPage) && ($count <= $endPage))
          { ?>
          <tr>
            <td><a href="edit-article.php?article_id=<?php echo $select_articles_row['article_id'];?>"><?php echo $select_articles_row['title']; ?></a></td>
            <td><a href="category-view.php?categoryid=<?php echo $select_articles_row['category_id'];?>"><?php echo $select_articles_row['category_name']; ?></a></td>
            <td><a href="author-view.php?userid=<?php echo $select_articles_row['user_id'];?>"><?php echo $select_articles_row['user_name']; ?></a></td>
            <td><?php echo $select_articles_row['date_posted']; ?></td>
            <?php if ($select_articles_row['date_published']!=null)
            { ?>
              <td><?php echo $select_articles_row['date_published']; ?></td>
            <?php }
            else
             { ?>
              <td>Not Published</td>
         <?php } ?>
            <td>
                <?php 
                /* Query SQL Server for comments count data. */
              $select_commentscount_sql = "select Count(*) As ArticleComments FROM comments where article_id=".$select_articles_row['article_id'] ;
                $select_commentscount_result = $dbHost->query($select_commentscount_sql);
                # setting the fetch mode
                $select_commentscount_result->setFetchMode(PDO::FETCH_ASSOC);
                $select_commentscount_row = mysql_fetch_array($select_commentscount_result);
                $totalComments = $select_commentscount_row["ArticleComments"];
                echo $totalComments;
                ?>
            </td>
            <td><a href="publish-data.php?articleid=<?php echo $select_articles_row['article_id']; if ($select_articles_row['date_published']!=null) { echo "&publish=delete";} ?>">    
            <?php if ($select_articles_row['date_published']==null)
            { ?><span class="glyphicon glyphicon-plus"></span> <?php } else { ?><span class="glyphicon glyphicon-remove red"></span><?php } ?></a></td>
      
            <td><a onclick="javascript:return confirm(&#39;Are you sure you want to delete this item <?php echo $select_articles_row['article_id'];?>&#39;);" id="delete1" href="delete-data.php?article_id=<?php echo $select_articles_row['article_id'];?>".><span class="glyphicon glyphicon-remove red"></span></a></td>
         <?php 
        }
         $count = $count+1;
       } ?>
         </tr>
        </tbody>
      </table>
<?php include('../includes/pagination.php'); ?>

<?php include '../includes/footer.php' ?>