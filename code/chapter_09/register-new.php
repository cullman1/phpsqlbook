<?php require_once('../includes/db_config.php');
      error_reporting(E_ALL | E_WARNING | E_NOTICE);
      ini_set('display_errors', TRUE);
require_once('../includes/mail1.php');
include '../includes/header-register.php';

function get_user_by_email($email) {
    $query = "SELECT * from user WHERE email = :email";
    $statement = $GLOBALS['connection']->prepare($query);
    $statement->bindParam(":email",$email);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    return $statement;
}

function insert_user($forename, $surname, $password, $email, $role, $date) {    
    $query = "INSERT INTO user (id,forename,surname,password,email,role_id,joined,active) 
            VALUES (uuid(),:name,:password,:email,:role,:date,0)";
    $statement = $GLOBALS['connection']->prepare($query);
    $statement->bindParam(":forename", $forename );
    $statement->bindParam(":surname", $surname );
    $statement->bindParam(":password", $password);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":role", $role);
    $statement->bindParam(":date", $date);
    $statement->execute();
    if( $statement->errorCode() != 00000 ) {     
        return '<div class="error">'.$statement->errorCode().'</div>';
    } else {
        return '<div class="success">User registered successfully</div>';
    }   
}

function confirm_email($email,$userid) { 
    $to = $email; 
    $subject = "Confirm your email";
    $message = "Click on the link to confirm your email";
    $message.="<a href='http://test.phpandmysqlbook.com/login/confirm-email.php?id=" 
    . $userid . "'>here<a>";
    $head ="MIME-Version: 1.0" . "\r\n";
    $head.="Content-type:text/html;charset=UTF-8"."\r\n";
    $head.='From: Admin<admin@deciphered.com>'."\r\n";
    mail($to, $subject, $message, $head);
} 

function validate_form($forename, $surname, $pwd, $email, $role) {
    $error = "";
    if (!empty($pwd) && !empty($forename) && !empty($surname) && !empty($email)) {
        $statement = get_user_by_email($email); 
        $num_rows = $statement->fetchColumn();
        if($num_rows) {		
            $error = "<div class='error'>This email has already been registered</div>";
        }   
    } else {
        $error ="<div class='error'>You haven't filled in all of the fields</div>";
    }
    if (password_strength($pwd)!="TRUE") {
        echo $pwd . " - " . password_strength($pwd);
        $error ="<div class='error'>Password is not strong enough!</div>";
    }
    return $error;
}

function password_strength($password) {
    $check1 = '/[a-zA-Z]/';  // Uppercase and lower case
    $check2 = '/[^a-zA-Z\d]/';  // Special
    $check3 = '/\d/';  // Numbers

    if(preg_match_all($check1, $password, $o)<1) return "FALSE1";
    if(preg_match_all($check2, $password, $o)<1) return "FALSE2";
    if(preg_match_all($check3, $password, $o)<1) return "FALSE3";
    if(strlen($password)<8) return "FALSE4";

    return "TRUE";
}

$error="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = validate_form($_POST['forename'], $_POST['surname'],$_POST['password'],
    $_POST['email'],2);
    if ($error=="") {
        $date = date("Y-m-d H:i:s");
        $error = insert_user($forename,$surname,$pwd,$email,$role, $date);
    }
}
if (!empty($error) && strpos($error,"div")==0) {
    $statement = get_user_by_email($_POST["email"]);
    while ($row = $statement->fetch()) {
        $error= confirm_email($_POST["email"],$row["user_id"]);
        echo $error;
    }
} else { ?>
<form class="indent" style="width:450px;" method="post" action="register-new.php">
 <label for="email">Email address</label>
 <input type="email" name="email" placeholder="Enter email" >
 <label for="forename">First name</label>
 <input type="text" name="forename" placeholder="Enter first name" >
 <label for="surname">Last name</label>
 <input type="text" name="surname" placeholder="Enter surname" >
 <label for="password">Password</label>
 <input type="password" name="password" placeholder="Enter password" >
 <button type="submit" class="btn">Register</button>
</form>
<?php echo $error;
            }  ?><?php include '../includes/footer-site.php' ?>