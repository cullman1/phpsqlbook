<?php

 function submit_login($connection) {
    $user =  $connection->get_user_by_email_passwordhash($_POST["emailAddress"], $_POST['password']); 
    if(sizeof($user)!=0) {
      if (!empty($user->{'user.id'})) {
        create_user_session($user);
        $user1= new User( $user->{'user.forename'} . ' '. $user->{'user.surname'},$user->{'user.email'},$user->{'user.id'});
        $_SESSION["user2"]=base64_encode(serialize($user1)); 
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/home/'); 
        exit;
      } 
    }
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/login/failed/');
    exit;
  }

function create_user_session($user) {
  $_SESSION['forename'] = $user->{'user.forename'};
  $_SESSION['image']    = ($user->{'user.image'} ? $user->{'user.image'} : 'default.jpg');
  $_SESSION['loggedin'] = $user->{'user.joined'};
}

 function submitLike() {
  if (!isset($_SESSION["user2"])) {
    header('Location: /phpsqlbook/login/');
  } else {    
   $this->connection->setLike($_REQUEST['liked'],$_REQUEST["user_id"], $_REQUEST["article_id"]);
   header('Location: /phpsqlbook/home/');
  }
}

 function submitLogout() {
 $_SESSION = array();
 setcookie(session_name(),'', time()-3600, '/');
 header('Location: /phpsqlbook/home/');
}
?>