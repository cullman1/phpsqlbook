<?php 
require_once('authenticate.php'); 
require_once('../includes/db_config.php');
function get_user($dbHost, $id) {
 $query = "select user_id,password,role_id,email,date_joined,full_name,image,active FROM user where user_id=:id";
 $statement = $dbHost->prepare($query);
 $statement->bindParam(":id",$id);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_ASSOC);
 return $statement;
}

function ban_user($dbHost, $id) {
    $query = "update user set active = active ^ 1 WHERE user_id= :id";
     $statement = $dbHost->prepare($query);
    $statement->bindParam(":id",$id);
    $statement->execute();
}

if (isset($_GET["ban"])) {
 ban_user($dbHost, $_GET["id"]);
}

include '../includes/header.php' ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Joined</th>
            <th>Ban User?</th>
          </tr>
        </thead>
        <tbody>
          <?php $statement = get_user($dbHost, $_GET["id"]);
                while($row = $statement->fetch()) { ?>
          <tr>
            <td><a href=""><?= $row['full_name']; ?></a></td>
            <td><a href="mailto:<?= $row['email']; ?>"><?= $row['email']; ?></a></td>
             <td><?php if (isset($row['image'])) { ?>
   <img width=50 src="../../../uploads/<?= $row['image']; ?>"/> <?php }  else { ?> <img width=50 src="../../../uploads/blank.png" /> <?php } ?></td>
            <td><?= $row['date_joined']; ?></td>
              <td><a href="view-user.php?ban=<?= $row['role_id'];  ?>&id=<?php echo $row['user_id']; ?>">    
            <?php if ($row['active']==0)
            { ?><span class="glyphicon glyphicon-ok"></span> <?php } else { ?><span class="glyphicon glyphicon-remove red"></span><?php } ?></a></td>
          </tr>
         <?php } ?>
        </tbody>
      </table>
<?php include '../includes/footer.php' ?>