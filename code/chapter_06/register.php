<?php require_once('../includes/db_config.php');
include '../includes/header-register.php';
$error="";
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
    $error="An error occurred registering the user!";
  }	
  return $error;	   
 } 

 function validate_form($dbHost, $forename, $lastName, $password, $email, $role) {
   $error = "";
   if (!empty($password) && !empty($forename) && !empty($lastName) && !empty($email) ) {
     $num_rows = get_existing_user($dbHost, $email);
        if($num_rows>0) {		
            $error = "<span class='red'>A user with that email address has already been registered!</span>";
        } else {
           $error = insert_user($dbHost, $forename, $lastName,$password,$email,$role,date("Y-m-d H:i:s"));
        }    
    } else {
       $error ="<span class='red'>&nbsp;You haven't filled in all of the fields correctly!</span>";
    }
    return $error;
  } 

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = validate_form($dbHost, $_POST['forename'], $_POST['surname'], $_POST['password'], $_POST['email'], $_POST["role"]);
  }

  if (!empty($error) && strpos($error,"span")==0) {
    echo $error;
  } else { ?>
 <form id="form1" class="indent" style="width:450px;" method="post" action="register.php">
      <h1>Please register:</h1>
           <label for="email">Email address</label>
           <input type="email"  name="email" placeholder="Enter email">
           <label for="forename">First name</label>
           <input type="text"  name="forename" placeholder="First name">
           <label for="surname">Last name</label>
           <input type="text"  name="surname" placeholder="Last name">
           <label for="password">Password</label>
           <input type="password"  name="password" placeholder="Password">
        <input id="role" name="role" type="hidden" value="2">  
  <button type="submit" class="btn btn-default">Register</button>
</form>
<?php echo $error;
 }  ?>
<?php include '../includes/footer-site.php' ?>