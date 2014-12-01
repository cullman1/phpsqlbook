<?php

/* Db Details */

/* Query SQL Server for selecting data. */

  $conn = mssql_connect('mssql2008R2.aspnethosting.co.uk:14330', 'eastcorn_ech', 'TVD!nner2');
  mssql_select_db('eastcorn_eastcornwallharriers',$conn);
  $select_user_sql = 'EXEC GetAllRunners';
  $select_user_result = mssql_query($select_user_sql) or die('Query failed: ' . mssql_get_last_message());;
  $numb =  mssql_num_rows($select_user_result);
include '../includes/header.php' ?>
<a class="btn btn-default" href="new-user.php" role="button">New user</a>    
<table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
    
           
 
          </tr>
        </thead>
          <tbody>
          <?php  
          while($select_user_row = mssql_fetch_assoc($select_user_result)) { ?>
          <tr>
            <td><a href=""><?php echo $select_user_row['RunnerName']; ?></a></td>
            <td><?php echo $select_user_row['Gender']; ?></td>
             
            <td><?php echo $select_user_row['Year']; ?></td>
           
              
          </tr>
         <?php } ?>
        </tbody>
      </table>
<?php include '../includes/footer.php' ?>
