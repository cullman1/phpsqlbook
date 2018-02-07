<?php
 require_once 'cms/config.php';                                   // Connect
 if (filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT)) {
    $user =  $cms->userManager->getUserById($_GET['user_id']);
  }
?>
<!DOCTYPE html>
<html>
  <head>   </head>
  <body>
    <h1>
      <?php  
        $email =  ( isset( $user->email) ? $user->email : '' );
        if ((filter_var($email, FILTER_VALIDATE_EMAIL))) {
          echo $user->forename . ' ' . $user->surname . ' : ' . $user->email;
        } else {
          echo "No User found"; 
        } 
      ?> 
    </h1>
  </body>
</html>