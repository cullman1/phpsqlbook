<?php
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$select_comments_sql = "select * FROM comments JOIN user ON comments.user_id = user.user_id JOIN article ON article.article_id = comments.article_id";
$select_comments_result = $dbHost->prepare($select_comments_sql);
$select_comments_result->execute();
$select_comments_result->setFetchMode(PDO::FETCH_ASSOC);
include '../includes/header.php' ?>
<!-- table of articles -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Comment</th>
            <th>Article</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while($select_comments_row =$select_comments_result->fetch()) { ?>
          <tr>
            <td>
                 <?php if  ($select_comments_row['role_id']==1) { ?>
                <a href="../admin/admin.php">
 <?php } else if  ($select_comments_row['role_id']==2) { ?>
                         <a href="../admin/admin.php">
                <?php } ?>
                <?php echo $select_comments_row['full_name']; ?></a></td>
            <td>
                <?php if ($select_comments_row['comment']=="This comment has been removed."){ ?>
                <span class="red">Deleted comment</span><?php 
                 } else { echo $select_comments_row['comment'];} ?>

            </td>
            <td><a href="../admin/edit-article.php?article_id=<?php echo $select_comments_row['article_id']; ?>"><?php echo $select_comments_row['title']; ?></a></td>
            <td><a href="../admin/delete-comment.php?comments_id=<?php echo $select_comments_row['comments_id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
          </tr>
           <?php } ?>
        </tbody>
      </table>
<?php include '../includes/footer.php' ?>