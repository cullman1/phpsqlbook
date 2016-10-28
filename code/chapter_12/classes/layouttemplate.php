<?php class LayoutTemplate {
  private $registry;
  private $server;
  private $pdo;
  private $category;
  private $parameters;
  public function __construct($server, $category, $parameters) {
    $this->registry = Registry::instance();
    $this->server = $server;
    $this->category = $category;
    $this->parameters = $parameters;
    $this->registry->set('database',new Database());
  }

  public function createPageStructure() { 

  switch($this->server) {
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
   default:
    $this->page_html = array("header1", "menu",  "login_bar", "search","divider","article","footer1");
    $this->content_html = array("content", "author", "like");
    break;     
  }
  switch($this->category) {
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
    if($this->parameters) {
     $this->assemblePage($part,$this->content_html,"single");   
    } else {
     $this->assemblePage($part,$this->content_html,"list");  
    }   
  } else {
   $this->getPart($part);
  }
 }
}

  public function assemblePage($part, $content, $contenttype) {
    $dbh = $this->registry->get('database');
    $article_ids = array();
    $count=0;
    foreach ($content as $content_part) {
      if ($contenttype=="list") {   
        if($content_part=="content") {
          $result = $dbh->get_article_list_sorted();    
          foreach ($result as $row) {
            $article_ids[$count]=$row->{"article.id"};
            $count++;
          }
          for($i=0;$i<sizeof($article_ids);$i++) {
            foreach ($content as $content_part) {
              if ($content_part == "content") {
                $this->getContentById($article_ids[$i]);
              } else {
                $this->getPart($content_part,$article_ids[$i]);
              }
            }
          }
        }
      } else {  
        $result2 = $dbh->get_article_by_name($this->parameters); 
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
  if (isset($_SESSION["user2"])) {
   $so = $_SESSION["user2"];
    $user_object = unserialize(base64_decode($so));
    $auth = $user_object->getAuthenticated(); 
  }
  $controller_modifier = $this->server."_"; 
   $dbhandler = $this->registry->get('database');   
  switch($part) {
   case "like":            
    $controller_modifier = "";
   
    if (isset($auth)) {
        $user_id = $auth;
    } else {
        $user_id = "0";
    }
    $this->parseTemplate($dbhandler->get_all_likes($user_id,$param), "like", $this->pdo);
   break;
   case "author":
    $controller_modifier = "";
    $this->parseTemplate($dbhandler->get_author_name($param),"author",$this->pdo);
    break;
    case "menu":
    $controller_modifier = "";
    $this->parseTemplate($dbhandler->get_category_list($param),"menu",$this->pdo);
    break;
   case "update":
   case "status":
    $controller_modifier = $query = "";

    if ($this->action=="success") {$query="success";}
        if ($this->action=="fail") {$query="fail";}
           echo "profile";
    $this->parseTemplate($dbhandler->getProfile($this->parameters[0]),"profile",$this->pdo,$part,$query);
   break;
   default:
    if ($part=="search"||$part=="menu"||$part=="login_bar"){ 
      $controller_modifier = ""; 
    }
    if ($this->server=="login" || $this->server=="profile" || $this->server=="register")
    {
        if ($part=="header"||$part=="footer") {
         $controller_modifier = "recipes_"; 
        }
    }
    include("templates/".$part.".php");     
    break;
 }
}

public function getContentById($articleid) { 
  $dbhandler = $this->registry->get('database');  
  $this->parseTemplate($dbhandler->get_article_by_id($articleid), '','');
}

public function getContent($articleid) { 
  $dbhandler = $this->registry->get('database');  
  $this->parseTemplate($dbhandler->get_article_by_name($this->parameters), '','');
}

public function parseTemplate($recordset,$prefix,$pdo, $extra="content", $query="") {
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
