<?php
error_reporting(E_ALL|E_WARNING|E_NOTICE);
ini_set('display_errors', TRUE); 
require_once('../includes/db_config.php'); 
 $query = 'SELECT * FROM user';       
 $statement = $dbHost->prepare($query);    
 $statement->execute();
 echo("SQL statement executed<br/>");
 if($statement->errorCode() != 0) {    
  die("Query failed"); 
 }                         
 $statement->setFetchMode(PDO::FETCH_ASSOC);        
 $users = $statement->fetchAll(); 
?>
<table>
 <tr><th>Row<th>Name</th><th>Email</th></tr>
 <?php $count=0;
 foreach ($users as $row) { ?>
   <tr>
    <?php echo "<td>".$count."</td>"; ?>
    <td><?php echo $row["full_name"]; ?></td>
    <td><?php echo $row["email"]; ?></td>
   </tr>
  <?php $count++;
        }
  ?>
</table>
<?php echo var_dump($users);
 ?>