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

 public function createPageStructure() { 
  $this->registry->set('LayoutTemplate',  new LayoutTemplate($this->controller,  $this->action, $this->parameters, $this->pdo ));  
  $layouttemplate = $this->registry->get('LayoutTemplate'); 

  switch($this->controller) {
   case "login":
    $this->page_html = array("header","menu","form","footer");
    break;
   case "register":
    $this->page_html = array("header","menu","form","footer");
    break;
   case "profile":
    if ($this->action=="view") {
       $this->page_html = array("header","login_bar","menu","status","footer");
    } else {
       $this->page_html = array("header","login_bar","menu","update","footer");
    }   
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
  case "add":
       $this->submitRegister();
       break;
  case "set":
       $this->setProfile();
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
   $layouttemplate->getPart($part);
  }
 }
}

public function assemblePage($part, $content, $contenttype) {
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

//Actions

public function submitLogout() {
 $_SESSION = array();
 session_write_close();
 setcookie(session_name(),'', time()-3600, '/');
 header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/recipes');
}

public function submitRegister() {
 $dbh = $this->registry->get('pdo');
  $db = $this->registry->get('configfile');
$error=-1;
if (!empty($_POST['password']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['emailAddress']) ) {
    if (!preg_match("#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_POST['password'])){
        $error=3;
    }    else {
    $query = "SELECT * from user WHERE email = :email";
    $statement = $dbh->prepare($query);
    $statement->bindParam(':email', $_POST['emailAddress']);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $statement->fetchAll();
    $num_rows = count($rows);
	    if($num_rows>0) {
            $error=0; /* User exists */
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/register/add/'.$error);
	    }		    else   {
 $passwordToken = sha1($db->getPreSalt() . $_POST['password'] . $db->getAfterSalt());		    
$query2 = "INSERT INTO user (full_name, password, email, role_id, date_joined, , active) VALUES (:name, :password, :email, :role, :date, 0)";
            $statement2 = $dbh->prepare($query2);
            $statement2->bindParam(':name', $_POST['firstName'] . " " . $_POST['lastName'] );
            $statement2->bindParam(':password', $passwordToken);
            $statement2->bindParam(':email', $_POST['emailAddress']);
            $statement2->bindParam(':role', $_POST['role']);
            $statement2->bindParam(':date', date("Y-m-d H:i:s"));
            $statement2->execute();
		    if($statement2->errorCode()!=0) {  
                /* Insert failed */
                $error=2;
                header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/register/add/'.$error);
            } else {
  			    /* Insert succeeded */
                $error=1;
	        }
	    }
    }
}

}


public function submitLike() {
 $dbh = $this->registry->get('DbHandler');
  if (!isset($_SESSION["user2"])) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/login');
  } else {    
   $dbh->setLike($this->pdo,$_REQUEST['liked'],$_REQUEST["user_id"], $_REQUEST["article_id"]);
   header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/recipes');
  }
}

function setProfile() {
 $dbh = $this->registry->get('DbHandler');
 $userImg = "";
 if(isset($_FILES['FILE'])) {
  if(!empty($_FILES['FILE']['name'])) {
   $img_name = $_FILES["FILE"]["name"];
   $userImg = ' ,user_img="'.$_FILES["FILE"]["name"].'"';
   $fldr = dirname(__FILE__) ."/assets/". $img_name;
   move_uploaded_file($_FILES['FILE']['tmp_name'],$fldr);
  }
 } 
 if(isset($_POST["Name"])) {
  $msg = $dbh->setProfile($this->pdo,$_POST["Id"],$_POST["Name"],$_POST["Email"],$_POST["Status"],$userImg);
if ($msg=="2") {
 header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/profile/fail/'.$_POST["Id"]);
  } else { 
 header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/profile/success/'.$_POST["Id"]);
  }
 }
}

public function submitLogin() {
  $dbh = $this->registry->get('DbHandler');
  $db = $this->registry->get('configfile');
  if(isset($_POST['password'])) {
    $passwordToken = sha1($db->getPreSalt() . $_POST['password'] . $db->getAfterSalt());
    $statement =  $dbh->getLogin($this->pdo, $_POST["emailAddress"], $passwordToken);
    while($row = $statement->fetch()) {
      if ($row[0]==1) {      
        $this->user_object = new User( $row[2],$row[3],$row[1]);
         $_SESSION["user2"]=base64_encode(serialize($this->user_object)); 
         header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/recipes');
      } else {
        /* Incorrect details */
	    header('Location: http://'.$_SERVER['HTTP_HOST'].'/cmsfull/login/login/3');
      }
    }
  }
}




} ?>