<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$select_user_sql = "select user_id,password,role_id,email,date_joined,full_name,image,active FROM user where role_id=2";
$select_user_result = $dbHost->prepare($select_user_sql);
$select_user_result->execute();
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);
include '../includes/header.php' ?>
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
            <th>Edit User?</th>
            <th>Ban User?</th>
          </tr>
        </thead>
        <tbody>
          <?php  while($select_user_row = $select_user_result->fetch()) { ?>
          <tr>
            <td><a href=""><?php echo $select_user_row['full_name']; ?></a></td>
            <td><a href="mailto:<?php echo $select_user_row['email']; ?>"><?php echo $select_user_row['email']; ?></a></td>
             <td><?php if (isset($select_user_row['image'])) { if($select_user_row['image']!="") {?><img width=50 src="../uploads/<?php echo $select_user_row['user_image']; ?>"/> <?php }  else { ?> <img width=50 src="../uploads/blank.png" /> <?php }  } else { ?> <img width=50 src="../uploads/blank.png" /> <?php } ?></td>
            <td><?php echo $select_user_row['date_joined']; ?></td>
            <td><?php 
                /* Query SQL Server for total comments data. */
                $query = "select Count(*) As ArticleComments FROM comments where user_id= :id";
                $statement = $dbHost->prepare($query);
                  $statement->bindParam(':id', $select_user_row['user_id']); 
                $statement->execute();
                $statement->setFetchMode(PDO::FETCH_ASSOC);
                $select_totalcomments_row = $statement->fetch();
                $totalComments = $select_totalcomments_row["ArticleComments"];
                echo $totalComments; ?>
            </td>
               <td><a href="edit-user.php?role=user&userid=<?php echo $select_user_row['user_id'];?>"><span class="glyphicon glyphicon-ok"></span></a></td>
            
              <td><a href="ban-user.php?publish=<?php echo $select_user_row['role_id'];  ?>&userid=<?php echo $select_user_row['user_id']; ?>">    
            <?php if ($select_user_row['active']==0)
            { ?><span class="glyphicon glyphicon-ok"></span> <?php } else { ?><span class="glyphicon glyphicon-remove red"></span><?php } ?></a></td>
          </tr>
         <?php } ?>
        </tbody>
      </table>
<?php include '../includes/footer.php' ?>