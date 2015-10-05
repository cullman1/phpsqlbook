<?php require_once('../classes/registry.php');
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
 private $parameters;
 private $user;
 public function __construct($controller,$action,$params) {
  $this->registry =Registry::instance();
  $this->controller=$controller;
  $this->action=$action;
  $this->parameters=$params;
  $this->registry->set('configfile', new Configuration());
  $db = $this->registry->get('configfile');
  $conn="mysql:host=".$db->getServerName().";dbname=" .$db->getDatabaseName();
  $this->pdo=new PDO($conn,$db->getUserName(), $db->getPassword());
  $this->pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES,true);
  $this->registry->set('pdo', $this->pdo );  
 } 

 public function createPageStructure() { 
 $this->registry->set('Layout',new LayoutTemplate($this->controller,$this->action,$this->parameters,$this->pdo ));  
 $layouttemplate = $this->registry->get('Layout');    
 switch($this->controller) {
 case "profile":
if ($this->action=="view") {
 $this->page_html = array("header", "login_bar",  "menu","status","footer");
} else {
 $this->page_html = array("header", "login_bar",  "menu","update","footer");
}   
break;
  case "login":
  $this->page_html = array("header","menu","form","footer");
  break;
   default:
      $this->page_html = array("header","login_bar", "menu", "search", "article","footer");
      $this->content_html = array("content", "author", "like","comments");
    break;     
  }
 switch($this->action) {
  case "add_comment":
       $this->addComment();
       break;
 case "set":
       $this->setProfile();
       break;
    case "likes":
       $this->submitLike();
       break;
case "failed":
 case "login":
  $this->submitLogin(); 
  break;
 case "logout":
  $this->submitLogout();
  break; } //empty for moment
 foreach($this->page_html as $part) {
   if($part == "article") {
   if($this->parameters[0]!="" && !isset($_GET["search"])){
    $this->assemblePage($part,$this->content_html,"single");   
    } else if (isset($_GET["search"])) {
     $this->assemblePage($part,$this->content_html,"search");  
    } else {
     $this->assemblePage($part,$this->content_html,"list");  
    }
  } else {
  $layouttemplate->getPart($part);
  }
 }
}

public function assemblePage($part,$content,$contenttype) {
 
$lt = $this->registry->get('Layout');
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
  
   $result = $dbh->getSearchResults($this->pdo, $_GET["search"]);    
  
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

public function submitLogin() {
 $dbh = $this->registry->get('DbHandler');
 $db = $this->registry->get('configfile');
 if(isset($_POST['password'])) {
 $passwordToken = sha1($db->getPreSalt().$_POST['password'].  $db->getAfterSalt());
 $statement = $dbh->getLogin($this->pdo,  $_POST["emailAddress"], $passwordToken);
  while($row = $statement->fetch()) {
  if ($row[0]==1) {      
   $this->user = new User($row[2],$row[3],$row[1]);
   $_SESSION["user2"]=base64_encode(serialize($this->user));
    header('Location: /cms/recipes');
   } else {
    header('Location: /cms/login/login/3');
   }
  }
 }
}

public function submitLogout() {
  $_SESSION = array();
  session_write_close();
  setcookie(session_name(),'', time()-3600, '/');
  header('Location: /cms/recipes');
}

public function submitLike() {
 $dbh = $this->registry->get('DbHandler');
 if (!isset($_SESSION["user2"])) {
   header('Location: /cms/login');
  } else {    
  $dbh->setLike($this->pdo,$_REQUEST['liked'],  $_REQUEST["user_id"], $_REQUEST["article_id"]);
   header('Location: /cms/recipes');
  }
}

function setProfile() {
 $dbh = $this->registry->get('DbHandler');
 $userImg = "";
 if(isset($_FILES['FILE'])) {
  if(!empty($_FILES['FILE']['name'])) {
   $img_name = $_FILES["FILE"]["name"];
   $userImg = ' ,image="'.$_FILES["FILE"]["name"].'"';
   $fldr = dirname(__FILE__) ."/assets/". $img_name;
   move_uploaded_file($_FILES['FILE']['tmp_name'],$fldr);
  }
 } 
if(isset($_POST["Name"])) {
  $msg = $dbh->setProfile($this->pdo,$_POST["Id"],
   $_POST["Name"],$_POST["Email"],$_POST["Status"],$userImg);
 if ($msg=="2") {
 header('Location: /cms/profile/fail/'.$_POST["Id"]);
  } else {
 header('Location: /cms/profile/success/'.$_POST["Id"]);
  }
 }
}

public function addComment() {
 $dbh = $this->registry->get('DbHandler');
if (!isset($_SESSION["user2"])) {
   header('Location: /cms/login');
 } else {    
   $commentid=0;
  if (isset($_POST["commentid"])) {
     $commentid = $_POST["commentid"];
   }
   $articleid =0;
   if (isset($_POST["articleid2"])) {
    $articleid = $_POST["articleid2"];
   } else {
     $articleid  = $this->parameters[0];
   }
  $so = $_SESSION["user2"];
  $user_object = unserialize(base64_decode($so));
  $auth = $user_object->getAuthenticated();
  $statement = $dbh->insertArticleComment($this->pdo, 
   $articleid,$auth,$_POST["commentText"],$commentid);	
  header('Location:/cms/recipes');
  }	      
}


} ?>