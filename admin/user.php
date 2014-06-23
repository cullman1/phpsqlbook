<?php 
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$tsql = "select * FROM user where role_id=2";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
?>
<?php include '../includes/header.php' ?>

      <a class="btn btn-default" href="new-user.php" role="button">New user</a>

      <!-- table of articles -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Joined</th>
            <th>Comments</th>
          </tr>
        </thead>
        <tbody>
          <?php  while($row = mysql_fetch_array($stmt)) { ?>
          <tr>
            <td><a href=""><?php echo $row['full_name']; ?></a></td>
            <td><a href=""><?php echo $row['email']; ?></a></td>
            <td><?php if (isset($row['user_image'])) { ?><img width=50 src="../uploads/<?php echo $row['user_image']; ?>"/> <?php } else { ?> <img width=50 src="../uploads/blank.png" /> <?php } ?></td>
            <td><?php echo $row['date_joined']; ?></td>
            <td><?php 
/* Query SQL Server for total records data. */
$tsql3 = "select Count(*) As ArticleComments FROM comments where user_id=".$row['user_id'] ;
$stmt3 = mysql_query($tsql3);
if(!$stmt3)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
$row3 = mysql_fetch_array($stmt3);
$totalComments = $row3["ArticleComments"];
echo $totalComments;
?></td>
          </tr>
         <?php } ?>
        </tbody>
      </table>

<?php include '../includes/footer.php' ?>