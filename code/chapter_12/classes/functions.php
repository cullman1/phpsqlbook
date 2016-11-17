<?php
function get_user_from_session() {
  if (isset($_SESSION["user2"])) {
      $so = $_SESSION["user2"];
      $user_object = unserialize(base64_decode($so));
      $auth = $user_object->getAuthenticated(); 
  }
  if (isset($auth)) {
       return $auth;
  }
  return "0";
}


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

function display_comments($recordset, $param) {   
  $root="http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12";
  $string=file_get_contents($root."/classes/templates/comments_content.php");
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $string, $matches);
  $opening_tag = strpos($string, "[[for]]");
  $closing_tag = strpos($string, "[[next]]",$opening_tag+1);     
  $string1= str_replace("[[for]]","", $string);
  $string2= str_replace("[[next]]","", $string1);
  $string3= str_replace("]","", $string2);
  $head= substr($string3, 0, $opening_tag);
  $remain = $closing_tag - $opening_tag;
  $body = array();
  $count=0;
  foreach ($recordset as $row) {
    if (!isset($_SESSION["user2"])) {
     $head= str_replace("Add a comment","",$head);
    }
    $cmnt=substr($string3,$opening_tag+1,$remain-9);
    if ($count==0) {
      foreach($matches[0] as $value) {           
        $replace= str_replace("{{","", $value);
        $replace= str_replace("}}","", $replace);
        $head=str_replace($value,$row->{$replace},$head);
      }  
    echo $head;
    }
    preg_match_all($regex, $cmnt, $inner_matches);
    foreach($inner_matches[0] as $value) {   
      $replace= str_replace("{{","", $value);
      $replace= str_replace("}}","", $replace);
      $cmnt=str_replace($value,$row->{$replace},$cmnt);    
      $body[$count] = $cmnt;
    }
    $count++;
  }
 for ($i=0;$i<$count;$i++) {
  echo $body[$i];
 }
 echo "</div></div></div></div>";
}

function display_comments2($recordset, $counter, $indent) {   
  $root="http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12";
  $string=file_get_contents($root."/classes/templates/comments_content2.php");
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $string, $matches);
  $opening_tag = strpos($string, "[[for]]");
  $closing_tag = strpos($string, "[[next]]",$opening_tag+1);
  $string1= str_replace("[[for]]","", $string);
  $string2= str_replace("[[next]]","", $string1);
  $string3= str_replace("]","", $string2);
  $head_temp= substr($string3, 0, $opening_tag);
  $remain = $closing_tag - $opening_tag;
  $combined_comments = array();
  $counter=0;
  foreach ($recordset as $row) {
    $sub_temp = substr($string3,$opening_tag+1,$remain-9);
    if ($counter==0) {
      foreach($matches[0] as $value) {           
        $replace= str_replace("{{","", $value);
        $replace= str_replace("}}","", $replace);
        $head_temp=str_replace($value,$row->{$replace},$head_temp);      
      }
      echo $head_temp;
    }           
    $combined_comments=recursive_check($regex, $sub_temp,$row,$combined_comments,$counter, $indent);
    $counter++;
  }
  
  echo "</div></div></div></div>"; 
}


 function submit_like($connection) {
  if (!isset($_SESSION["user2"])) {
    header('Location: /phpsqlbook/login/');
  } else {    
   $connection->setLike($_GET['liked'],$_GET["user_id"], $_GET["article_id"]);
   if(isset($_SERVER['HTTP_REFERER'])) {
     header('Location: '.$_SERVER['HTTP_REFERER']);
   } else {
     header('Location: /phpsqlbook/home/');
   }
  }
}

function add_comment($connection, $articleid, $commentid) {
  if (!isset($_SESSION["user2"])) {
    header('Location: /phpsqlbook/login');
   } else {   
    $user_id = get_user_from_session(); 
    $connection->insert_article_comment($articleid, $user_id, $_POST["commentText"], $commentid);
    header('Location:/phpsqlbook/home');
  }	      
}

function create_tree(&$list, $parent){
  $tree = array();
  foreach ((array) $parent as $key=>$reply) {
    if (isset($list[$reply->{'comments.id'}])) {
      $reply->{'children'} = create_tree($list, $list[$reply->{'comments.id'}]);
    }
    $tree[] = $reply;
  } 
  return $tree;
}

function recursive_check($regex, $sub_temp, $row, $combine_comments, $counter, $indent) {
 if (isset($row->{'children'})) {       
    $combine_comments=tag_replace($regex, $sub_temp, $row, $combine_comments, $counter, $indent);
      echo $combine_comments[$counter];
    $counter++;
    $indent+=10;
    foreach ($row->{'children'} as $row2) {    
      $combine_comments = recursive_check($regex, $sub_temp, $row2, $combine_comments, $counter, $indent);
    }      
  } else {      
      $combine_comments =tag_replace($regex,$sub_temp, $row, $combine_comments, $counter, $indent);
      echo $combine_comments[$counter];
      $counter++;
      $indent=0;
  } 
   if (!isset($_SESSION["user2"])) {
      $combine_comments= str_replace("Add a comment","",  $combine_comments);
    }
  return $combine_comments;
}

function tag_replace($regex, $sub_temp, $row, $combined_comments,$counter, $indent) {
  preg_match_all($regex, $sub_temp, $inner_matches);
  foreach($inner_matches[0] as $value) {   
    $replace= str_replace("{{","", $value);
    $replace= str_replace("}}","", $replace);
    $sub_temp=str_replace($value,$row->{$replace},$sub_temp);  
    if ($indent > 0) { 
       $combined_comments[$counter]="<div style='margin-left:".$indent."px'>".$sub_temp."</div>"; 
    } else {
        $combined_comments[$counter] = $sub_temp;
    }
  }
 
  return $combined_comments; 
}
?>