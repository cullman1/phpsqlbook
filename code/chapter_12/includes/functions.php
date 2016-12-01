<?php
require_once('../classes/user.php');

function get_user_from_session() {
  if (isset($_SESSION["user2"])) {
      $so = $_SESSION["user2"];
      $user_object = unserialize(base64_decode($so));
      $auth = $user_object->authenticated; 
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
        $user1 =  new User('', $user->{'user.id'}, $user->{'user.forename'} , $user->{'user.surname'},$user->{'user.email'},$user->{'user.password'},$user->{'user.joined'},$user->{'user.image'}, $user->{'user.id'});
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

function display_comments($recordset, $commentcount) {   
   $string=file_get_contents("http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12/classes/templates/comments_content.php");
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $string, $matches);
  $opening_tag = strpos($string, "[[for]]");
  $closing_tag = strpos($string, "[[next]]",$opening_tag+1);     
  $string1= str_replace("[[for]]","", $string);
  $string2= str_replace("[[next]]","", $string1);
  $head= substr($string2, 0, $opening_tag);
  preg_match_all($regex, $head, $head_matches);
  $remain = $closing_tag - $opening_tag;
  $body = array();
  $count=0; 
  if (!isset($_SESSION["user2"])) {
     $head= str_replace("Add a comment","",$head);
  }
  foreach ($recordset as $row) {
    $row->{'comment.commentcount'} = $commentcount; 
    $comment=substr($string2,$opening_tag+1,$remain-9);
    if ($count==0) {
        $head = field_replace($head, $head_matches[0],$row);       
        echo $head;
    }
    if ($commentcount>0) {
    preg_match_all($regex, $comment, $inner_matches);
    $comment = field_replace($comment, $inner_matches[0],$row); 
    $body[$count] = $comment;
    $count++;
    }
  }
 for ($i=0;$i<$count;$i++) {
  echo $body[$i];
 }
 echo "</div></div></div></div>";
}

function field_replace($body, $matches, $row) {
      foreach($matches as $value) {         
        $replace= str_replace("{{","", $value);
        $replace= str_replace("}}","", $replace);
        try {
          $body=str_replace($value,$row->{$replace},$body);
        } catch (Exception $ex) { echo $ex; }
      } 
      return $body; 
}


function display_comments2($recordset, $check, $indent) {   
  $root="http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12";
  $string=file_get_contents($root."/classes/templates/comments_content2.php");
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $string, $matches);
  $opening_tag = strpos($string, "[[for]]");
  $closing_tag = strpos($string, "[[next]]",$opening_tag+1);
  $string1= str_replace("[[for]]","", $string);
  $string2= str_replace("[[next]]","", $string1);
  $head= substr($string2, 0, $opening_tag);
  $remain = $closing_tag - $opening_tag;
  $body = array();
  $count=0;
  foreach ($recordset as $row) {
    if (!isset($_SESSION["user2"])) {
     $head= str_replace("Add a new comment","",$head);
    }
    $comments = substr($string2,$opening_tag+1,$remain-9);
    if ($count==0) {
      $head = field_replace($head, $matches[0],$row); 
      echo $head;
    }        
    if( $row->{'.Total'} > 0) {
      $body=recursive_check($regex, $comments,$row,$body,$count, $indent, $check);
    }
    $count++;   
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

function recursive_check($regex, $body, $row, $combined, $counter, $indent, $check) {
  $combined= tag_replace($regex, $body, $row, $combined, $counter, $indent);
  if (!isset($_SESSION["user2"]) || ($check ==0)) {
    $combined[$counter]= str_replace("Reply to this comment","",$combined[$counter]);
  }
  echo $combined[$counter];
  $counter++;
  if (isset($row->{'children'})) {         
    $indent+=20;
    foreach ($row->{'children'} as $row2) {    
      $combined = recursive_check($regex, $body, $row2, $combined, $counter, $indent, $check);
    }      
  } else {      
    $indent=0;
  } 
   if (!isset($_SESSION["user2"])) {
      $combined= str_replace("Add a comment","",  $combined);
    }
  return $combined;
}

function tag_replace($regex, $body, $row, $combined_comments,$counter, $indent) {
  preg_match_all($regex, $body, $inner_matches);
  foreach($inner_matches[0] as $value) {   
    $replace= str_replace("{{","", $value);
    $replace= str_replace("}}","", $replace);
    $body=str_replace($value,$row->{$replace},$body);  
    if ($indent > 0) { 
       $combined_comments[$counter]="<div style='margin-left:".$indent."px'><img src='/phpsqlbook/code/chapter_12/assets/plus.png' style='float:left;width:16px;padding-right:4px;'/>".$body."</div>"; 
    } else {
        $combined_comments[$counter] = $body;
    }
  }
  return $combined_comments; 
}

  

function getArticlesByCategory($connection, $show, $from, $sort='', $dir='ASC', $category = 0, $name='') {
    $query= "select article.*, category.* FROM article JOIN user ON user.id = user_id JOIN category ON category.id= category_id where published <= now()";
    //category list
    if (($category > 0) && (!empty($name))) {
       $query .= ' AND  title=:name AND category_id = :id';
    } else if ($category > 0) {
      $query .= ' AND category_id = :id';
    }
    //Sort
    if (!empty($sort)) {
      $query .= " Order By " . $show . " " . $dir;
    }
    //Get actual limited page of articles
      if (!empty($show)) {
      $query .= " limit " . $show . " offset " . $from;
    }
     $statement =$connection->prepare($query);
    if (($category > 0) && (!empty($name))) {
       $statement->bindParam(":name", $name); 
       $statement->bindParam(":id", $category); 
    }  else if ($category > 0) {
     $statement->bindParam(":id", $category);    
    }
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article_list = $statement->fetchAll();  
    $article_list = hyphenate_url($article_list);
    return $article_list;
}

function getArticlesBySearch($connection, $show='', $from='', $sort='', $dir='ASC', $search = '', $author_id='0') {
    $query= "select article.*, category.* FROM article JOIN user ON user.id = user_id JOIN category ON category.id= category_id where published <= now()";
    $search_wildcards = "%". trim($search) . "%";    
    if (!empty($search)) {  //search results
      $searchsql = " AND ((title like :search)";
      $searchsql .= " OR (content like :search))";
      $query .= $searchsql;   
    }
    //author list
    if ($author_id > 0) {
      $query .= ' AND user.id = :id';
    }
    //Sort
    if (!empty($sort)) {
      $query .= " Order By " . $show . " " . $dir;
    }
    //Get actual limited page of articles
    if (!empty($show)) {
      $query .= " limit " . $show . " offset " . $from;
    }
    $statement = $connection->prepare($query);
    if ($author_id > 0) {
        $statement->bindParam(":id", $author_id);    
    }
     if (!empty($search)) {  
         $statement->bindParam(":search", $search_wildcards);    
     }
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article_list = $statement->fetchAll();  
    $article_list = hyphenate_url($article_list);
      if (!empty($search) && !empty($show)) {
      foreach($article_list as $article) {
        $article->{'article.content'} = str_ireplace($search, "<b style='background-color:yellow'>".$search."</b>", $article->{'article.content'}); 
      }
    }
    return $article_list;
}

 function hyphenate_url($article_list) {
    foreach ($article_list as $article) {
        $article->{"article.title_url"} = str_replace(' ','-', $article->{"article.title"});
    }
    return $article_list;
}

  function getUserById($connection, $id) { 
  $query = "select article.*, user.* FROM article JOIN user ON article.user_id = user.id JOIN category ON article.category_id = category.id where article.id= :article_id";
 $statement = $connection->prepare($query);
 $statement->bindValue(':article_id', $id, PDO::PARAM_INT);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_OBJ);
 $user = $statement->fetchAll();  
 return $user;
}

?>