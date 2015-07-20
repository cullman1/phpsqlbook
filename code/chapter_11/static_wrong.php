<?php require_once('../includes/db_config.php');
require_once('../classes/user_static.php');

$select_user_result = $dbHost->prepare("select  * from Users where email_address='morton@acme.org'");
$select_user_result->execute();
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);
 /* Redirect to original page */
    while($select_user_row = $select_user_result->fetch()) {
        

            $login_object = new Login($select_user_row["total_log_ins"] ); 

           
            
      
    }

 include '../includes/header.php'; ?>
 <form id="form1" method="post" action="new-user-short.php" enctype="multipart/form-data">
         <?php echo "Logins:" . $login_object::getCount() . "<br/>"; ?>    
         <button type="submit" class="btn btn-default">Click to Login</button><br/>  <br/>
          
       </form>
<?php include '../includes/footer.php' ?>