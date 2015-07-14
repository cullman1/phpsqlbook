<?php require_once('../includes/db_config.php');
require_once('../classes/user.php');
$submitted="";
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ((empty($_POST['password']) || empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email'])))) {
    $submitted="missing";
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passwordToken = sha1($preSalt . $_POST['password'] . $afterSalt);
    $sel_usr_set = $dbHost->prepare("SELECT * from user WHERE email = :email");
    $sel_usr_set->bindParam(":email",$_POST['email']);
    $sel_usr_set->execute();
    $row = $sel_usr_set->fetchAll();
	if(count($row)>0) {
  		    $submitted="false";
	} else {
            if(isset($_FILES['img'])) {
                $img_name = $_FILES["img"]["name"];
                $folder = "../uploads/". $img_name;
                move_uploaded_file($_FILES['img']['tmp_name'], $folder);
            }   
            $ins_usr_set = $dbHost->prepare("INSERT INTO user (full_name, password, email, date_joined, role_id, user_image, active) VALUES (:name, :password, :email, :date_joined, 2, :image, 0)");
            $name = $_POST['firstName'] . " " . $_POST['lastName'];
            $ins_usr_set->bindParam(":name", $name); 
$password = "test1234";   
            $ins_usr_set->bindParam(":password",$password);  
            $ins_usr_set->bindParam(":email", $_POST["email"]);      
            $date = date("Y-m-d H:i:s");
            $ins_usr_set->bindParam(":date_joined",$date);    
            $ins_usr_set->bindParam(":image",$img_name);    
            $ins_usr_set->execute();
		    if($ins_usr_set->errorCode()!=0) {  die("Insert User Query failed"); }
		    else {
  			    $submitted="true";
                $user = new user($name, $_POST["email"], 2);
	        }
	}
}
 include '../includes/header.php'; ?>
 <form id="form1" method="post" action="new-user-short.php" enctype="multipart/form-data">
      <div class="col-md-4">
            
           <label for="firstName">First name
           <input type="text" class="form-control" name="firstName" placeholder="First name"></label>
           <label for="lastName">Last name
           <input type="text" class="form-control" name="lastName" placeholder="Last name"></label>
            <label for="emailAddress">Email address
           <input type="email" class="form-control" name="email" placeholder="Enter email"></label>  
           <label for="password">Password
           <input type="password" class="form-control" name="password" placeholder="Password">
           <label for="img">Upload user image
           <input type="file" id="img" name="img"></label>
        </div>          
         <button type="submit" class="btn btn-default">Create User</button><br/>  <br/>
          <div id="Status_Post">
         <?php if($submitted=="true") {
                  echo "<span class='red'>User successfully registered!</span>";
                 } else if ($submitted=="false") {
                  echo "<span class='red'>A user with that email address has already been registered! Please either login or use a different password.</span>";
                 } else if($submitted=="missing") {
                   echo "<span class='red'>You haven't filled in all of the fields!</span>";
                 } ?>
         </div>
       </form>
<?php include '../includes/footer.php' ?>