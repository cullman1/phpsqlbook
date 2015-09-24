<?php 
require_once('../classes/registry.php');
require_once('../classes/dbhandler.php');
require_once('../classes/layouttemplate.php');
require_once('../classes/user.php');

class Controller {
  private $registry;
  private $controller;
  private $action;
  private $page_html;
  private $content_html;
  private $pdo;
  private $user_object;



  public function __construct($controller,$action, $parameters) { 
    $this->registry = Registry::instance();
    $this->controller=$controller;
    $this->action=$action;
    $this->parameters=$parameters;
    $this->registry->set('configfile', new Configuration());
    $db = $this->registry->get('configfile');
    $conn="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
    $this->pdo  = new PDO($conn,$db->getUserName(),$db->getPassword()); 
    $this->pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
    $this->registry->set('pdo', $this->pdo );
  }

  public function submitLogout() {
   $this->user_object = new User( "","",0);
         $_SESSION["user2"]=serialize($this->user_object); 
  // Unset all of the session variables.
$_SESSION = array();
session_write_close();
setcookie(session_name(),'', time()-3600, '/');


/* Redirect */
 header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/recipes');
  }

public function submitLogin() {
  $dbh = $this->registry->get('pdo');
  $db = $this->registry->get('configfile');
  if(isset($_POST['password'])) {
    $passwordToken = sha1($db->getPreSalt() . $_POST['password'] . $db->getAfterSalt());
    $query = "SELECT Count(*) as CorrectDetails, user_id, full_name, email from user WHERE email ='".$_POST['emailAddress']."' AND password= '".$passwordToken."'" ." AND active= 0";
    $statement = $dbh->prepare($query);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_BOTH);
    while($select_user_row = $statement->fetch()) {
      if ($select_user_row[0]==1) {      
        $this->user_object = new User( $select_user_row[2],$select_user_row[3],$select_user_row[1]);
         $_SESSION["user2"]=base64_encode(serialize($this->user_object)); 
header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/recipes');
      
      } else {
        /* Incorrect details */
	    header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/login/login/3');
      }
    }
  }
}

 public function createPageStructure() { 
  switch($this->controller) {
   case "login":
    $this->page_html = array("header","menu","form","footer");

    break;
   case "admin":
    $this->page_html = array("header","menu","article", "footer");
    $this->content_html = array("content");
    break;
   default:
    $this->page_html = array("header","login_bar", "search", "menu","article","footer");
    $this->content_html = array("content", "author", "like");
    break;     
  }
  switch($this->action) {
   case "failed":
   case "login":
    $this->submitLogin();
   
    break;
   case "logout":
       $this->submitLogout();
       break;
   case "likes":
       $this->submitLike();
       break;
  }

  foreach($this->page_html as $part) { 
   if($part == "article") {
    if($this->parameters[0]!="" && !isset($_GET["search"])) {
     $this->assemblePage($part,$this->content_html,"single");   
    } else if (isset($_GET["search"])) {
     $this->assemblePage($part,$this->content_html,"search");  
    } else {
     $this->assemblePage($part,$this->content_html,"list");  
    }   
  } else {
 
   $this->registry->set('LayoutTemplate',  new LayoutTemplate($this->controller,  $this->action, $this->parameters, $this->pdo ));  
   $layouttemplate = $this->registry->get('LayoutTemplate'); 
   $layouttemplate->getPart($part);
  }
 }
}

public function assemblePage($part, $content, $contenttype) {
 $this->registry->set('LayoutTemplate', new LayoutTemplate($this->controller, $this->action, $this->parameters, $this->pdo ));  
 $lt = $this->registry->get('LayoutTemplate');
 $dbh = $this->registry->get('DbHandler');
 $article_ids = array();
 $count=0;
 switch($contenttype) {
  case "list":
  $result = $dbh->getArticleList($this->pdo);    
   while ($row=$result->fetch()) {
    $article_ids[$count]=$row["article.article_id"];
    $count++;
   }
   break;
  case "search":
  $result = $dbh->getSearchResults($this->pdo);    
   while ($row=$result->fetch()) {
    $article_ids[$count]=$row["article.article_id"];
    $count++;
   }
   break;
  default:
  $article_ids[0]=$this->parameters[0];
   break;
 }
  for($i=0;$i<sizeof($article_ids);$i++) {
 foreach ($content as $content_part) {
  if ($content_part == "content") {
   $lt->getContent($article_ids[$i]);
   } else {
   if ($this->parameters[0]==""||is_numeric($this->parameters[0])||isset($_GET["search"])) {   
$lt->getPart($content_part, $article_ids[$i]);
    } else {  
    $result2 = $dbh->getArticleByName($this->pdo,$this->parameters); 
     while ($row=$result2->fetch()) {
     $article_ids[0]=$row["article.article_id"];
     }          
     $lt->getPart($content_part, $article_ids[0]);
    }
   }
  }
 }
}

public function submitLike() {
  if (!isset($_SESSION["user2"])) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/login');
  } else {    
    if($_REQUEST['liked']=="0") {
      $query = "INSERT INTO article_like (user_id, article_id) VALUES (:userid, :articleid)";
    } else {
      $query = "DELETE FROM article_like WHERE user_id= :userid and article_id= :articleid";
    }
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(":userid", $_REQUEST["user_id"]);
    $statement->bindParam(":articleid", $_REQUEST["article_id"]);
    $statement->execute();
    if ($statement->errorCode()!=0) {  die("Query failed"); }
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/recipes');
  }
}


} ?>