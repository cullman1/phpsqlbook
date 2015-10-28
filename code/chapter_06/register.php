<?php require_once('../includes/db_config.php');
include '../includes/header-register.php';
  $form_error = array('email' => '');
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_REQUEST['password']) && !empty($_REQUEST['forename']) && !empty($_REQUEST['lastName']) && !empty($_REQUEST['emailAddress']) ) {
        $num_rows = get_existing_user($dbHost, $_POST['emailAddress']);
        if($num_rows>0) {		
            $form_error["email"] = "<span class='red' style='color:red;'>A user with that email address has already been registered! Please either login or use a different password.</span>";
        }		    else {
            $form_error["email"] = insert_user($dbHost, $_POST['forename'], $_POST['lastName'],$_POST['password'],$_POST['emailAddress'],$_POST['role'],date("Y-m-d H:i:s"));
        }    
    } else {
       $form_error["email"] ="<span class='red' style='color:red;'>You haven't filled in all of the fields correctly!</span>";
    }
  }

function  get_existing_user($dbHost, $email) {
   $query = "SELECT * from user WHERE email = :email";
    $statement = $dbHost->prepare($query);
    $statement->bindParam(":email",$email);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $statement->fetchAll();
    return count($rows);
}

function insert_user($dbHost, $firstName, $lastName, $password, $email, $role, $date) { 
  $error = "User successfully registered!";		    
  $query = "INSERT INTO user (full_name, password, email, role_id, date_joined) VALUES (:name, :password, :email,:role,:date)";
  $statement = $dbHost->prepare($query);
  $name = $firstName . " " .$lastName;
  $statement->bindParam(":name", $name );
  $statement->bindParam(":password",$password);
  $statement->bindParam(":email",$email);
  $statement->bindParam(":role",$role);
  $statement->bindParam(":date",$date);
  $statement->execute();
  if($statement->errorCode()!=0) {     
    $error="<span class='red' style='color:red;'>An error occurred registering the user</span>";
  }	
  return $error;	   
 } ?>
 <form id="form1" method="post" action="register.php">
      <h1>Please register:</h1>
               <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email">
         </div>
         <div class="form-group">
           <label for="firstName">First name</label>
           <input type="text" class="form-control" id="forename" name="forename" placeholder="First name">
         </div>
         <div class="form-group">
           <label for="lastName">Last name</label>
           <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name">
         </div>
         <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         </div>
        <input id="role" name="role" type="hidden" value="2">  
         <button type="submit" class="btn btn-default">Register</button>
      </div>
</form>
<?php echo $form_error['email']; ?>
<?php include '../includes/footer-site.php' ?>