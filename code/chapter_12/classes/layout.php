<?php 
require_once('../classes/user.php');

class Layout {
  private $registry;
  private $server;
  private $category;
  private $parameters;
  private $connection;
  private $page_html = array();
  private $content_html = array();
  private $message;

  public function __construct($server, $category, $parameters) {
    $this->registry = Registry::instance();
    $this->server = $server;
    $this->category = $category;
    $this->parameters = $parameters;
    $this->registry->set('database',new Database());
    $this->connection = $this->registry->get('database');  
  }

  public function createPageStructure() { 
    //Page structure
      $recordset = "";

    switch($this->category) {
      case "login":
        $this->page_html = array("header1","menu","search","divider","form","footer");
        break;
      case "register":
        $this->page_html = array("header1","menu","search","divider","register_form","footer");
        break;
      case "Contact":
      case "About":
        $this->page_html = array("header1", "menu", "login_bar", "search","divider","article","footer1");
        $this->content_html = array("content");
        break;
      case "profile":
        if ($this->parameters=="view") {
            $recordset = $this->connection->getProfile($_GET["id"]);
          $this->page_html = array("header1","login_bar","menu","status","footer");
        } else {
          $this->page_html = array("header1","login_bar","menu","update","footer");
        }   
        break;
      case "search":
      default:
        $this->page_html = array("header1", "menu",  "login_bar", "search","divider","article","footer1");
        $this->content_html = array("content", "author", "like");
        break;     
    }

    //Page action to take
    switch($this->parameters) {
        case "failed":
          $this->message = "Login has failed, please try again!";
          break;
        case "password-not-strong-enough":
          $this->message = "Your password is not strong enough, please try again!";
          break;
         case "user-exists":
          $this->message = "A user with this email address already exists, please try logging in!";
          break;
          case "insert-failed":
          $this->message = "The database was unable to add your details, please try again!";
          break;
            case "insert-succeeded":
          $this->message = "You are now registered!";
          break;
        case "login":
          $this->submitLogin(); 
          break;
        case "logout":
          $this->submitLogout();
          break;
        case "add":
          $this->connection->submitRegister();
          break;
        case "view":
       //   $result = $this->connection->getProfile($_GET["id"]);
      //      $this->getPart("ProfileStatus", $result);
          break;
          case "set":
          $this->connection->setProfile();
          break;
        case "likes":
          $this->submitLike();
          break;
     }
     foreach($this->page_html as $part) { 
       if($part == "article") {
         if($this->parameters) {
           $this->assemblePage($part,$this->content_html,"single");   
         } else {
           $this->assemblePage($part,$this->content_html,"list");  
         }   
       } else {
           if (!empty($recordset)) {
               $this->getPart($part,$recordset);
           } else {
               $this->getPart($part);
           }
       }
    }
  }

  public function assemblePage($part, $content, $contenttype) {
    $article_ids = array();
    $count=0;
    $result = null;
    foreach ($content as $content_part) {
      if ($contenttype=="list") {   
        if($content_part=="content") {
          $category = $this->connection->get_category_by_name($this->category);    
          if (isset($category->{'category.id'}) ==0 ) {
            $result = $this->connection->get_article_list_sorted();    
          } else {
            $result = $this->connection->get_articles_by_category($category->{'category.id'});    
          }
          if ($this->category=="search") {
             $result = $this->connection->get_search_results();   
          }
          foreach ($result as $row) {
            $article_ids[$count]=$row->{"article.id"};
            $count++;
          }
          for($i=0;$i<sizeof($article_ids);$i++) {
            foreach ($content as $content_part) {
              if ($content_part == "content") {
                $this->getContentById($article_ids[$i], $this->category);
              } else {
                $this->getPart($content_part,$article_ids[$i]);
              }
            }
          }
        }
      } else {  
        $result2 = $this->connection->get_article_by_name($this->parameters); 
        foreach ($result2 as $row) {
          $article_ids[0]=$row->{'article.id'};
        } 
        if ($content_part != "content") {
          $this->getPart($content_part, $article_ids[0]);
        } else {         
          $this->getContent($article_ids[0]);
        }
      }
    }
  }

public function getPart($part, $param="") {
 // if (isset($_SESSION["user2"])) {
 //  $so = $_SESSION["user2"];
 //   $user_object = unserialize(base64_decode($so));
 //   $auth = $user_object->getAuthenticated(); 
 // }
  $controller_modifier = "";
  switch($part) {
   case "like":     
    $user_id=0;       
    if (isset($auth)) {
        $user_id = $auth;
    } else {
        $user_id = "0";
    }
    $this->parseTemplate($this->connection->get_all_likes($user_id,$param), "like");
   break;
   case "author":
    $this->parseTemplate($this->connection->get_author_name($param),"author");
    break;
   case "menu":
    $this->parseTemplate($this->connection->get_category_list($param),"menu");
    break;
   case "update":
   case "status":
    $controller_modifier = $query = "";
    if ($this->parameters =="success") {$query="success";}
        if ($this->parameters=="fail") {$query="fail";}
    $this->parseTemplate($this->connection->getProfile($_GET["id"]),"profile",$part,$query);
   break;
   default:
     include("templates/".$part.".php");     
     break;
 }
}

public function getContentById($articleid,$category) { 
  if ($category != "search") { $category="";}
  $this->parseTemplate($this->connection->get_article_by_id($articleid, $category), '');
}

public function getContent($articleid) { 
  $this->parseTemplate($this->connection->get_article_by_name($this->parameters), '');
}

public function submitLogin() {
  if(isset($_POST['password'])) {
    $passwordToken =  $_POST['password'] ;
    $user =  $this->connection->get_user_by_email_passwordhash($_POST["emailAddress"], $passwordToken); 
    if(sizeof($user)!=0) {
      if (!empty($user->{'user.id'})) {
        $this->user_object = new User( $user->{'user.forename'} . ' '. $user->{'user.surname'},$user->{'user.email'},$user->{'user.id'});
        $_SESSION["user2"]=base64_encode(serialize($this->user_object)); 
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/home/'); 
       } else {
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/login/failed/');
       }  
    } else {
     header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/login/failed/');
    }
  }
}

public function submitLike() {
  if (!isset($_SESSION["user2"])) {
    header('Location: /phpsqlbook/login/');
  } else {    
   $this->connection->setLike($_REQUEST['liked'],$_REQUEST["user_id"], $_REQUEST["article_id"]);
   header('Location: /phpsqlbook/home/');
  }
}

public function submitLogout() {
 $_SESSION = array();
 session_write_close();
 setcookie(session_name(),'', time()-3600, '/');
 header('Location: /phpsqlbook/home/');
}

public function parseTemplate($recordset,$prefix, $extra="content", $query="") {
  $root="http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12/";
  $string = file_get_contents($root. "/classes/templates/".$prefix. $extra.".php?query=".$query);  
  $regex = '#{{(.*?)}}#';
  $template="";
  preg_match_all($regex, $string, $matches);
  foreach ($recordset as $row) {
    $template=$string;
    foreach($matches[0] as $value) {           
      $replace= str_replace("{{","", $value);
      $replace= str_replace("}}","", $replace);

      $template = str_replace($value,$row->{$replace}, $template);  
    }  
  echo $template;  
  }	
                 
}

} ?>
