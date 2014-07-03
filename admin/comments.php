<?php
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');


/* Query SQL Server for selecting data. */
$tsql = "select * FROM comments JOIN user ON comments.user_id = user.user_id JOIN article ON article.article_id = comments.article_id";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

?>
<?php include '../includes/header.php' ?>

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
          while($row = mysql_fetch_array($stmt)) { ?>
          <tr>
            <td>
                 <?php if  ($row['role_id']==1) { ?>
                <a href="../admin/admin.php">
 <?php } else if  ($row['role_id']==2) { ?>
                         <a href="../admin/admin.php">
                <?php } ?>
                <?php echo $row['user_name']; ?></a></td>
            <td><?php echo $row['comment']; ?></td>
            <td><a href="../admin/editarticle2.php?article_id=<?php echo $row['article_id']; ?>"><?php echo $row['title']; ?></a></td>
            <td><a href=""><span class="glyphicon glyphicon-remove"></span></a></td>
          </tr>
           <?php } ?>
        </tbody>
      </table>

<?php include '../includes/footer.php' ?>