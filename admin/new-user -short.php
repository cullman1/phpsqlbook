<?php require_once('../includes/db_config.php');
require_once('../classes/user.php');
$submitted="";
if (empty($_POST['password']) || empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['emailAddress']) ) {
    $submitted="missing";
} else {
    $passwordToken = sha1($preSalt . $_POST['password'] . $afterSalt);
    $select_user_sql = "SELECT * from user WHERE email = '".$_POST['emailAddress']."'";
    $select_user_result = $dbHost->prepare($select_user_sql);
    $select_user_result->execute();
    $select_user_rows = $select_user_result->fetchAll();
    $num_rows = count($select_user_rows);
	if($num_rows>0) {
  		    $submitted="false";
	    } else	    {
            if(isset($_FILES['uploader'])) {
                $name = $_FILES["uploader"]["name"];
                $folder = "../uploads/". $name;
                move_uploaded_file($_FILES['uploader']['tmp_name'], $folder);
            }
		    $insert_user_sql = "INSERT INTO user (full_name, password, email, role_id, date_joined, user_image, active) VALUES ('".$_POST['firstName']." ".$_POST['lastName']."', '".$passwordToken."', '".$_POST['emailAddress']."','".$_POST['Role']."', '". date("Y-m-d H:i:s") ."', '". $name ."', 0)";
            $insert_user_result = $dbHost->prepare($insert_user_sql);
            $insert_user_result->execute();
		    if($insert_user_result->errorCode()!=0) {  die("Insert User Query failed"); }
		    else {
  			    $submitted="true";
	        }
	    }
}
 include '../includes/header.php'; ?>
 <form id="form1" method="post" action="new-user-short.php">
      <div class="col-md-4">
           <label for="emailAddress">Email address
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email"></label>    
           <label for="firstName">First name
           <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name"></label>
           <label for="lastName">Last name
           <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name"></label>
           <label for="password">Password
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
           <label for="uploader">Upload user image
           <input type="file" id="uploader" name="uploader"></label>
        </div>
        <input id="Role" name="Role" type="hidden" value="2" />              
         <button type="submit" class="btn btn-default">Create User</button><br/>  <br/>
          <div id="Status_Post">
         <?php if($submitted!=="true") {
                  echo "<span class='red' style='color:red;'>User successfully registered!</span>";
                 } else if($_POST['submitted']=="false") {
                  echo "<span class='red' style='color:red;'>A user with that email address has already been registered! Please either login or use a different password.</span>";
                 } else if($_POST['submitted']=="missing") {
                   echo "<span class='red' style='color:red;'>You haven't filled in all of the fields!</span>";
                 } ?>
         </div>
       </form>
<?php include '../includes/footer.php' ?>