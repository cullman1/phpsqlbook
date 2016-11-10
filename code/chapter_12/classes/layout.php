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
  private $from;
  private $to;

  public function __construct($server, $category, $parameters) {
    $this->registry = Registry::instance();
    $this->server = $server;
    $this->category = $category;
    $this->parameters = $parameters;
    $this->registry->set('database',new Database());
    $this->connection = $this->registry->get('database');  
  }

  public function createPageStructure() { 

    $this->show = ( isset($_GET['show'])     ? $_GET['show']       : '5' );
    $this->from =  ( isset($_GET['from'])       ? $_GET['from']       : '0' );
   
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
  }

  public function checkParameters() { 
    //Page action to take
    switch($this->parameters) {
        case "logout":
          submit_logout();
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
  }

  public function chooseSingleOrMultipleArticles() {
    $recordset = "";
    foreach($this->page_html as $part) { 
       if($part == "article") {
         if($this->parameters && $this->category !="search") {
             $this->assemblePage($part,$this->content_html,"single");   
         } 
         $this->assemblePage($part,$this->content_html,"list", $this->show, $this->from);
       } else {
           if ($this->category=="profile") {
                $recordset = $this->connection->getProfile($_GET["id"]);
           } 
           $this->getPart($part, $recordset);
       }
    }
  }

  public function assemblePage($part, $content, $contenttype) {
    $article_ids = array();
    $count=0;
    $result = null;
    
    //For each section of the page
    foreach ($content as $content_part) {

      //If this is a list of articles
      if (($contenttype=="list") && ($content_part=="content")) {   
          
          //Get the category
          $category = $this->connection->get_category_by_name($this->category);    
          
          //If there's no category present
          if (isset($category->{'category.id'})==0 ) {
            
            //Get all articles
            $result = $this->connection->get_article_list_sorted($this->show, $this->from);    
          } else {
            
            //Otherwise just get the articles for that category 
            $result = $this->connection->get_articles_by_category($category->{'category.id'}, $this->show, $this->from);    
          }

          //If this is a search with parameters set in the url (as all searches now are)
          if (($this->category=="search") && (isset($this->parameters))) {
            $result = $this->connection->get_search_results($this->parameters, $this->show, $this->from);   
          }
         
          //Grab all the article ids
          $total = 0;
          foreach ($result as $row) {
            $article_ids[$count]=$row->{"article.id"};
            $total = $row->{"article.count"};
            $count++;
          }

          //If we've got more than zero articles
          if (sizeof($result)!=0) {
            for($i=0;$i<sizeof($article_ids);$i++) {
              foreach ($content as $content_part) {
                if ($content_part == "content") {
                  //If it's content we need, get the article id, one at a time
                  $this->getContentById($article_ids[$i], $this->category);
                } else {
                  //Otherwise just pull the page part/section we need instead
                  $this->getPart($content_part,$article_ids[$i]);
                }
              }
            }

            //After displaying the list of articles add the paging
            echo (create_pagination($total,$this->show,$this->from));
          
          } else {

            //There were zero articles returned by our query.
            echo "No articles found";
          }
        } else if (($contenttype!="list") && ($content_part=="content")) {  
          
          //Otherwise this is a single article and it is content - if it isn't content we don't anything run at all.
          $result2 = $this->connection->get_article_by_name($this->parameters); 

          //To get this article into the same template as a list of articles we need to add it to the first item of our array
          foreach ($result2 as $row) {
            $article_ids[0]=$row->{'article.id'};
          } 

          //If it isn't content, then grab a part
          if ($content_part != "content") {
            $this->getPart($content_part, $article_ids[0]);
          } else {         
            //Otherwise just grab the content once.
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

public function getContentById($articleid, $category) { 
  $search= '';
  if ($category != "search") { 
    $category="";
  } else { 
   if(isset($this->parameters)) {
    $search =$this->parameters; 
    }
   if(isset($_POST["search"])) {
    $search = $_POST["search"]; 
    }
  }
  $this->parseTemplate($this->connection->get_article_by_id($articleid, $category, $search), '');
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
