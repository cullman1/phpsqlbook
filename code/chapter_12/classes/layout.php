<?php 
require_once('user.php');
require_once('functions.php');
class Layout {
  private $registry;
  private $server;
  private $category;
  private $parameters;
  private $connection;
  private $page_html = array();
  private $content_html = array();
  private $message;
  private $status;
  private $error = array('id'=>'', 'title'=>'','article'=>'','template'=>'','email'=>'','password'=>'','mimetype'=>'','date'=>'','datetime'=>'');

  public function __construct($server, $category, $parameters) {
    $this->registry = Registry::instance();
    $this->server = $server;
    $this->category = $category;
    $this->parameters = $parameters;
    $this->registry->set('database',new Database());
    $this->connection = $this->registry->get('database');  
  }

  public function createPageStructure() { 
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
          $recordset = $this->connection->getProfile($_GET["id"]);
        if ($this->parameters!="view") {
          $this->page_html = array("header1","login_bar","menu","search","divider","status","footer");
        } else {
          $this->page_html = array("header1","login_bar","menu","search","divider","update","footer");
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
          $this->status = "alert-danger";
          $this->message = "Login has failed, please try again!";
          break;
        case "password-not-strong-enough":
          $this->status = "alert-danger";
          $this->message = "Your password is not strong enough, please try again!";
          break;
        case "user-exists":
          $this->status = "alert-danger";
          $this->message = "A user with this email address already exists, please try logging in!";
          break;
        case "insert-failed":
          $this->status = "alert-danger";
          $this->message = "The database was unable to add your details, please try again!";
          break;
        case "insert-succeeded":
          $this->status = "alert-success";
          $this->message = "You are now registered!";
          break;
        case "check":
          submit_login($this->connection, $this->registry); 
          break;
        case "logout":
          submit_logout();
          break;
        case "add":
          $this->connection->submitRegister();
          break;
        case "update":
            if(isset($_POST['submit'])){
               $this->connection->setProfile($_POST["Id"],$_POST["Forename"],$_POST["Surname"],$_POST["Email"],$_FILES["img"]["name"] );
               if ($_FILES["img"]['tmp_name'] == '') {
                 echo  'Your image did not upload.';
               } else {
                 $temporary   = $_FILES["img"]['tmp_name'];
                 $destination = "c:\\xampp\htdocs\phpsqlbook\uploads\\" . $_FILES['img']['name'];
                 if (move_uploaded_file($temporary, $destination)) {
                   echo "file saved.";
                 } else {
                   echo 'File could not be saved.';
                 }
               }
            }
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
