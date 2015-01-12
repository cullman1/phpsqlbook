<?php  
/* Include passwords and login details */
require_once('../includes/db_config.php');
require_once('../classes/user.php');

  
/* Query SQL Server for checking user details. */
if(isset($_REQUEST['password']))
{
    $passwordToken = sha1($preSalt . $_REQUEST['password'] . $afterSalt);
    $select_user_sql = "SELECT Count(*) as CorrectDetails, user_id, full_name, email from user WHERE email ='".$_REQUEST['emailAddress']."' AND password= '".$passwordToken."'" ." AND active= 0";
    $select_user_result = $dbHost->prepare($select_user_sql);
    $select_user_result->execute();
    $select_user_result->setFetchMode(PDO::FETCH_ASSOC);

    /* Redirect to original page */
    while($select_user_row = $select_user_result->fetch()) {
        if ($select_user_row["CorrectDetails"]==1) {
            //require_once('../classes/FileSessionHandler.php');
            session_start();
            $user_object = new User( $select_user_row["full_name"],$select_user_row["email"],$select_user_row["user_id"]);
            $s =serialize($user_object);
            
            $_SESSION["user2"] = $s;
         
            if (isset($_REQUEST["page"])) {
               if ($_REQUEST["page"]=="pages") {
                    header('Location:../admin/pages.php');
               }
            }
            else
            {
              header('Location:../pages/main.php');   
            }
        }
        else
        {
            /* Incorrect details */
			header('Location:../login/login-user.php?login=failed');
        }
    }
}
include '../includes/header-register.php' ?>
 <form id="form1" method="post" action="login-user.php">
       <div class="wholeform">
         <br/>
      <div class="col-md-4"><h1>Please login:</div>
      <div class="col-md-4">
        <form role="form">
         <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email">
         </div>
         <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         </div>
         <button type="submit" class="btn btn-default">Login</button>
         <br/>
         <span> </span>
         <br/>
          <div id="Status" ><?php 
    
    if(isset($_REQUEST['login']))
    {
    echo "<br/><span class='red'>Login failed</span>";
    }

    ?></div>
  </div>
       </form>
      </div>

    </div> <!-- /container -->
   
</form>
<?php include '../includes/footer-site.php' ?>
