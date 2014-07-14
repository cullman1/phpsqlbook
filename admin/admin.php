<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$select_user_sql = "select * FROM user where role_id=1";
$select_user_result = mysql_query($select_user_sql);
if(!$select_user_result) { die("Query failed: ". mysql_error()); }
include '../includes/header.php' ?>
<a class="btn btn-default" href="new-admin.php" role="button">New admin</a>
      <!-- table of articles -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
             <th>Image</th>
            <th>Joined</th>
            <th>Comments</th>
              <th>Edit User?</th>
          </tr>
        </thead>
        <tbody>
          <?php  while($select_user_row = mysql_fetch_array($select_user_result)) { ?>
          <tr>
            <td><a href=""><?php echo $select_user_row['full_name']; ?></a></td>
            <td><a href="mailto:<?php echo $select_user_row['email']; ?>"><?php echo $select_user_row['email']; ?></a></td>
                 <td><?php if (isset($select_user_row['user_image'])) { if($select_user_row['user_image']!="") {?><img width=50 src="../uploads/<?php echo $select_user_row['user_image']; ?>"/> <?php }  else { ?> <img width=50 src="../uploads/blank.png" /> <?php }  } else { ?> <img width=50 src="../uploads/blank.png" /> <?php } ?></td>
            <td><?php echo $select_user_row['date_joined']; ?></td>
            <td>
            <?php 
            /* Query SQL Server for total records data. */
                     $select_totalcomments_sql = "select Count(*) As ArticleComments FROM comments where user_id=".$select_user_row['user_id'] ;
            $select_totalcomments_result = mysql_query($select_totalcomments_sql);
            if(!$select_totalcomments_result) {  die("Query failed: ". mysql_error()); }
            $select_totalcomments_row = mysql_fetch_array($select_totalcomments_result);
            $totalComments = $select_totalcomments_row["ArticleComments"];
            echo $totalComments; ?>
            </td>
                <td><a href="edit-user.php?userid=<?php echo $select_user_row['user_id'];?>"><span class="glyphicon glyphicon-ok"></span></a></td>
          </tr>
         <?php } ?>
        </tbody>
      </table>
<?php include '../includes/footer.php' ?>