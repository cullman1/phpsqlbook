<?php
/* Db Details */
require_once('../includes/db_config.php');
/* Query SQL Server for selecting data. */

$select_user_result = $dbHost->prepare("CALL select_user");
$select_user_result->execute();
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);
 
include '../includes/header.php' ?>
<a class="btn btn-default" href="new-user.php" role="button">New user</a>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Joined</th>
          </tr>
        </thead>
          <tbody>
          <?php  while($select_user_row = $select_user_result->fetch()) { ?>
          <tr>
            <td><a href=""><?php echo $select_user_row['full_name']; ?></a></td>
            <td><a href="mailto:<?php echo $select_user_row['email']; ?>"><?php echo $select_user_row['email']; ?></a></td>
             <td><?php if (isset($select_user_row['user_image'])) { if($select_user_row['user_image']!="") {?><img width=50 src="../uploads/<?php echo $select_user_row['user_image']; ?>"/> <?php }  else { ?> <img width=50 src="../uploads/blank.png" /> <?php }  } else { ?> <img width=50 src="../uploads/blank.png" /> <?php } ?></td>
            <td><?php echo $select_user_row['date_joined']; ?></td>    
          </tr>
         <?php } ?>
        </tbody>
      </table>
<?php include '../includes/footer.php' ?>
