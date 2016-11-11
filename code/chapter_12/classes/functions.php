<?php
 function submit_login($connection, $email, $password) {
    $user =  $connection->get_user_by_email_passwordhash($email, $password); 
    if(sizeof($user)!=0) {
      if (!empty($user->{'user.id'})) {
        create_user_session($user);
        $user1 =  new User($user->{'user.forename'} . ' '. $user->{'user.surname'},$user->{'user.email'},$user->{'user.id'});
        $_SESSION["user2"]=base64_encode(serialize($user1)); 
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/home/'); 
        exit;
      } 
    } 
    return array('status' => 'danger', 'message' =>'Login failed, Please try again');
  }

  function submit_register($connection, $firstName, $lastName, $password, $email) {
    $alert  =   array('status' => '', 'message' =>'');
    $statement = $connection->get_user_by_email( $email, $password);
    if(sizeof($statement)!=0) {
      $alert  =   array('status' => 'danger', 'message' =>'User exists, please try another email or login');
    } else   {   
      $statement2 = $connection->add_user($firstName, $lastName,$password, $email);
      if($statement2===true) {  
        $alert  =   array('status' => 'success', 'message' =>'Registration succeeded');
      } else {
        $alert  =   array('status' => 'danger', 'message' =>'Registration failed');
      }
    }
    return $alert;
  }
 
function create_user_session($user) {
  $_SESSION['forename'] = $user->{'user.forename'};
  $_SESSION['image']    = ($user->{'user.image'} ? $user->{'user.image'} : 'default.jpg');
  $_SESSION['loggedin'] = $user->{'user.joined'};
}

 function submit_like($connection) {
  if (!isset($_SESSION["user2"])) {
    header('Location: /phpsqlbook/login/');
  } else {    
   $connection->setLike($_GET['liked'],$_GET["user_id"], $_GET["article_id"]);
   header('Location: /phpsqlbook/home/');
  }
}

 function submit_logout() {
 $_SESSION = array();
 setcookie(session_name(),'', time()-3600, '/');
 header('Location: /phpsqlbook/home/');
}

function create_pagination($count, $show, $from, $search) {
  $total_pages  = ceil($count / $show);   // Total matches
  $current_page = ceil($from / $show) + 1;    // Current page

  $result  = '';
  if ($total_pages > 1) {
    for ($i = 1; $i <= $total_pages; $i++) {
      if ($i == $current_page) {
        $result .= $i . '&nbsp;';
      } else {
        $result .= '<u><a href="?show=' . $show;
         if (isset($search)) {
         $result .= '&search='.$search; 
        }
        $result .= '&from=' . (($i-1) * $show) . '">' . ($i) . '</a></u>&nbsp;';
       
       }
    }
  }
  echo "<br/>" . $result;
}
?>