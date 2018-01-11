<?php
 require_once('cms/config.php');                                   // Connect
 $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

 $id2 = filter_var($_GET["id"], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>10)));
// if (filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>10))) === true) {
 $user =  $userManager->getUserById($id);
//}
?>
<!DOCTYPE html>
<html>
  <head> ...  </head>
  <body>
    <h1>
      <?php  
        $email =  ( isset( $user->email) ? $user->email : '' );
        if ((filter_var($email, FILTER_VALIDATE_EMAIL))) {
        echo $id2;
          //echo $user->forename . ' ' . $user->surname . ' : ' . $user->email;
        } else {
       //   echo "No User found"; 
              echo $id2;
        } 
      ?> 
    </h1>
  </body>
</html>