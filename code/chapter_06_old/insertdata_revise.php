<?php require_once('../includes/db_config.php');
      include '../includes/header-register.php';
      if (!empty($_POST['pwd']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) ) {   
        $sel_user_set = $dbHost->prepare("SELECT * from user WHERE email = :email");
        $sel_user_set->bindParam(":email",$_POST['email']);
        $sel_user_set->execute();
        $sel_user_rows = $sel_user_set->fetchAll(PDO::FETCH_ASSOC);
        $num_rows = count($sel_user_rows);
        if($num_rows>0) {
			echo ("<div class='wholeform'>User already exists</div>");        
        }	
        else {
            $ins_user_set = $dbHost->prepare("INSERT INTO user (full_name, password, email, role_id, date_joined, active) VALUES (?,?,?,?,2,0)");
            $full_name = $_POST['firstName'] . " " . $_POST['lastName'];
            $today= date("Y-m-d H:i:s");
            $ins_user_set->bindParam("ssss", $full_name, $_POST['pwd'], $_POST['email'], $today);          
            $ins_user_set->execute();
            if($ins_user_set->errorCode()!=0) {  
                echo ("<div class='wholeform'>User registration failed</div>");        
            }
	        else {
                echo ("<div class='wholeform'>User registration succeeded</div>");    
	        }
       }
      } ?>
 <form id="form1" method="post" action="insertdata_revise.php">
  <div class="wholeform">
      <div class="col-md-4"><h1>Please register:</h1></div>
         <div class="form-group">
           <label for="email">Email address</label>
           <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
         </div>
         <div class="form-group">
           <label for="firstName">First name</label>
           <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name">
         </div>
         <div class="form-group">
           <label for="lastName">Last name</label>
           <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name">
         </div>
         <div class="form-group">
           <label for="pwd">Password</label>
           <input type="pwd" class="form-control" id="password" name="pwd" placeholder="Password">
         </div>      
        <button type="submit" class="btn btn-default">Register</button>
   </div>
</form>
<?php include '../includes/footer-site.php' ?>

