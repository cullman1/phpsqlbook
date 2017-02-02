<?php
 $GLOBALS['connection'] = new PDO("mysql:host=127.0.0.1;dbname=cms", 
                                  'root', '');
     $GLOBALS['connection']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

function get_user_from_session() {
  if (isset($_SESSION["login"])) {
      $so = $_SESSION["user2"];
      $user_object = unserialize(base64_decode($so));
      $auth = $user_object->authenticated; 
  }
  if (isset($auth)) {
       return $auth;
  }
  return "0";
}

 function get_user_by_email($connection, $email) {
  $query = "SELECT * from user WHERE email = :email";
    $statement =$connection->prepare($query);
    $statement->bindParam(':email',$email);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $author_list = $statement->fetchAll();
   return $author_list;
}



 function submit_login($connection, $email, $password) {
    $user =  $connection->get_user_by_email_passwordhash($email, $password); 
    if(sizeof($user)!=0) {
      if (!empty($user->{'user.id'})) {
        create_user_session($user);
        $user1 =  new User($user->{'user.id'}, $user->{'user.forename'} , $user->{'user.surname'},$user->{'user.email'},$user->{'user.password'},$user->{'user.joined'},$user->{'user.image'}, $user->{'user.id'});
        $_SESSION["user2"]=base64_encode(serialize($user1)); 
        $_SESSION["login"]=$user->{'user.id'}; 
        if (isset($_SERVER['HTTP_REFERER'])) {
              header('Location: /phpsqlbook/admin/');
        } else {
              header('Location: /phpsqlbook/home/');
        }
        exit;
      } 
    } 
    return array('status' => 'danger', 'message' =>'Login failed, Please try again');
  }

  function submit_register($connection, $firstName, $lastName, $password, $email) {
    $alert  =   array('status' => '', 'message' =>'');
    $statement = get_user_by_email($connection, $email, $password);
    if(sizeof($statement)!=0) {
      $alert  =   array('status' => 'danger', 'message' =>'User exists, please try another email or login');
    } else   {   
      $statement2 = add_user($connection,$firstName, $lastName,$password, $email);
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
  $_SESSION['image']  = ($user->{'user.image'} 
                         ? $user->{'user.image'} 
                         : 'default.jpg');
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



  function add_user($connection, $forename, $surname, $password, $email) {     
  $query = 'INSERT INTO user (forename, surname, email, password) 
            VALUES (:forename, :surname, :email, :password)';
  $statement = $connection->prepare($query);
  $statement->bindParam(':forename', $forename );
  $statement->bindParam(':surname', $surname );
  $statement->bindParam(':email',$email);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $statement->bindParam(':password',$hash);
  $result = $statement->execute();
  if( $result == true ) {     
      return true;
  } else {
      return $statement->errorCode();
  }  
 }



  function get_article_by_id($id) {
    $query = "select article.*, category.* FROM article JOIN user ON article.user_id = user.id JOIN category ON article.category_id = category.id where article.id= :id";
 //$connection->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);   
  $statement = $connection->prepare($query);
    
    $statement->bindParam(":id", $id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article = $statement->fetch(); 
    $article = $this->hyphenate_url($article_list);
    return $article; 
  }

  function get_user_by_article_id($id) { 
   $query = "SELECT article.*, user.* FROM article JOIN user ON article.user_id = user.id  
   JOIN category ON article.category_id = category.id where article.id= :article_id";
   $GLOBALS['connection']->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true); 
   $statement = $GLOBALS['connection']->prepare($query);
   $statement->bindValue(':article_id', $id, PDO::PARAM_INT);
   $statement->execute();
   $statement->setFetchMode(PDO::FETCH_OBJ);
   $user = $statement->fetch();  
   return append_blank($user,'blank.png');;
}


  function getUserById($connection, $id) { 
  $query = "select user.* FROM user  where id= :user_id";
 $statement = $connection->prepare($query);
 $statement->bindValue(':user_id', $id, PDO::PARAM_INT);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_OBJ);
 $user = $statement->fetch();  
 return append_blank($user,'blank.png');;
}

 function getUserByArticleId($connection, $id) { 
   $query = "select article.*, user.* FROM article JOIN user ON article.user_id = user.id JOIN category ON article.category_id = category.id where article.id= :article_id";
   $statement = $connection->prepare($query);
   $statement->bindValue(':article_id', $id, PDO::PARAM_INT);
   $statement->execute();
   $statement->setFetchMode(PDO::FETCH_OBJ);
   $user = $statement->fetch();  
   return append_blank($user,'blank.png');;
}

 function append_blank($user, $image) {

      if (empty($user->image)) {
        $user->image = $image;
      }

    return $user;
}

function field_replace($body, $matches, $row) {
  foreach($matches as $value) {         
    $replace = str_replace("{{","", $value);
    $replace = str_replace("}}","", $replace);
    $body =str_replace($value,$row->{$replace},$body);
  } 
  return $body; 
}

function hyphenate_url($article_list) {
  foreach ($article_list as $article) {
    $article->{"article.title_url"} = str_replace(' ','-', $article->title);
  }
  return $article_list;
}

function get_articles_by_category( $show, $from, $sort='', 
$dir='ASC',$category=0, $name='') {
  $query= "SELECT category.*, article.*  FROM article JOIN 
           user ON user.id = user_id JOIN category ON 
       category.id= category_id WHERE published <= now()";
  //If category id not 0 and name present, 
  //add a clause with id and name to the SQL
  if (($category > 0) && (!empty($name))) {
    $query .= ' AND  title=:name AND category_id = :id';
  } 
  //Else if only category id not 0, only add id clause
  else if ($category > 0) {
    $query .= ' AND category_id = :id';
  }
  //If sort not add a sort clause
  if (!empty($sort)) {
    $query .= " Order By " . $show . " " . $dir;
  }
  //Get limited page of articles
  if (!empty($show)) {
    $query .= " limit " . $show . " offset " . $from;
  }
  //  $GLOBALS['connection']->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true); 
  $statement = $GLOBALS['connection']->prepare($query);
  //Get limited page of articles
  if (($category > 0) && (!empty($name))) {
     $statement->bindParam(":name", $name); 
     $statement->bindParam(":id", $category); 
  }  else if ($category > 0) {
     $statement->bindParam(":id", $category);    
  }
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $article_list = $statement->fetchAll();  
  return hyphenate_url($article_list);
}

function get_articles_by_search($show='', $from='',
$sort='', $dir='ASC', $search='', $user='0') {
  $query= "SELECT article.*, category.* FROM article JOIN
           user ON user.id = user_id JOIN category ON 
      category.id= category_id where published <= now()";
  $search_wildcards = "%". trim($search) . "%"; 
  //If search, and wildcards  
  if (!empty($search)) {   
    $searchsql = " AND ((title like :search)";
    $searchsql .= " OR (content like :search))";
    $query .= $searchsql;   
  }
  //If user id not 0, add user id clause
  if ($user > 0) {     
    $query .= ' AND user.id = :id';
  }
  //If sort not empty, add a sort
  if (!empty($sort)) {    
    $query .= " Order By " . $show . " " . $dir;
  }
  //Get limited page of articles
  if (!empty($show)) {  
    $query .= " limit " . $show . " offset " . $from;
  }
  $statement =$GLOBALS['connection']->prepare($query);
  //If user id not 0 bind parameter
  if ($user > 0) {          
    $statement->bindParam(":id", $user);    
  }
  if (!empty($search)) { 
    $statement->bindParam(":search", $search_wildcards);
  }
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $article_list = $statement->fetchAll();  
  $article_list = hyphenate_url($article_list);
  //If search not empty, highlight search term
  if (!empty($search) && !empty($show)) { 
    foreach($article_list as $article) {
      $article->content =str_ireplace($search,
      "<b class='yellow'>".$search."</b>", 
      $article->content); 
    }
  }
  return $article_list;
}

function logout_user() {
 $_SESSION = array();
 setcookie(session_name(),'', time()-3600, '/');
}

// Get categories
function getCategoryList() {
  $query = 'SELECT * FROM category'; // Query
  $statement = $GLOBALS["connection"]->prepare($query); 
  $statement->execute(); 
   $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();      // Step 4 Get all rows ready to display
  return $category_list;
}
function getCategoryListArray($id) {
  $query = 'SELECT id, name, template FROM category'; // Query
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_ASSOC);   // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();      // Step 4 Get all rows ready to display
  return $category_list;
}

function getCount($connection,$article_id, $user_id) {
  $query = "select count(*) as likes_count FROM article_like where article_id=:artid and user_id=:userid "; 
  $statement = $connection->prepare($query);
  $statement->bindParam(':artid', $article_id);
  $statement->bindParam(':userid',$user_id);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);  
  return $statement->fetchAll()->{".likes_count"};  
}

function getTotal($connection, $article_id) {
  $query = "select count(article_id) as likes_total FROM like where article_id=:artid"; 
  $statement = $connection->prepare($query);
  $statement->bindParam(':artid', $article_id);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);  
 return $statement->fetchAll()->{".likes_total"};  

}

?>