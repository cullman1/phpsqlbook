<?php
  error_reporting(E_ALL|E_WARNING|E_NOTICE);
  ini_set('display_errors', "1"); 
  include('../includes/database_connection.php'); 
try { 
 $query = 'SELECT * FROM user';       
  $statement = $connection->prepare($query);
  $statement->execute();
    echo("SQL statement executed<br/>");
 $statement->fetch(PDO::FETCH_ASSOC);
    $users = $statement->fetchAll();
  }
  catch (PDOException $e) {
    die("Connection failed- error: " . $e);
 }
?>
<table>
 <tr>
   <th>Row</th>
   <th>Name</th>
   <th>Email</th>
</tr>
 <?php $count=0;
 foreach ($users as $row) { ?>
   <tr>
    <?php echo "<td>Row ".$count."</td>"; ?>
    <td><?php echo $row["forename"] . ' ' . $row["surname"]  ?></td>
    <td><?php echo $row["email"]; ?></td>
   </tr>
  <?php $count++; if ($count==2){break;}
        }  ?>
</table>
 <?php var_dump($users); ?>