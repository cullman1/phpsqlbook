<?php 
require_once('user.php');
require_once('validate.php');
require_once('functions.php');

class Layout {
  private $registry;
  private $server;
  private $category;
  private $parameters;
  private $connection;
  private $page_html = array();
  private $content_html = array();
  private $search;
  private $error = array('id'=>'', 'title'=>'','article'=>'','template'=>'','email'=>'','password'=>'','mimetype'=>'','date'=>'','datetime'=>'','firstName'=>'','lastName'=>'', 'image'=>'');
  private $from;
  private $show;

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
    $this->search =  ( isset($_GET['search'])       ? $_GET['search']       : '' );
    
    switch($this->category) {
      case "login":
        $this->page_html = array("header1","menu","login_bar","search","divider","login_form","footer");
        break;
      case "register":
        $this->page_html = array("header1","menu","search","divider","register_form","footer");
        break;
      case "Contact":
      case "About":
        $this->page_html = array("header1", "menu", "login_bar", "search","divider","article","footer1");
        $this->content_html = array("no_date_content");
        break;
      case "profile":
        if ($this->parameters=="status") {
          $this->page_html = array("header1","menu","login_bar","search","divider","profile_status","footer");
        } else {
          $this->page_html = array("header1","menu","login_bar","search","divider","profile_update","footer");
        }             
        break;
      case "search":
      default:
        $this->page_html = array("header1", "menu",  "login_bar", "search","divider","article","footer1");
        $this->content_html = array("main_content", "author", "like");
        break;     
    }
  }

  public function checkParameters() { 
    //Page action to take
    switch($this->parameters) {
        case "logout":
          submit_logout();
          break;     
        case "likes":
         submit_like($this->connection);
          break;
     }
  }

  public function assemblePage() {
    foreach($this->page_html as $part) { 
       if($part == "article") {
         $this->assembleArticles($part,$this->content_html);
       } else {
         $this->getPart($part);
       }
    }
  }

  public function assembleArticles($part, $content) {
    $article_ids = array();
    $count=0;
    $result = null;
    $search= '';

    //For each section of the page
    foreach ($content as $content_part) {

      //If this is a content part
      if (strpos($content_part,"content")) {   
          
        //Get the category
        $category = $this->connection->get_category_by_name($this->category);    
         
        //Get all articles
        $result = $this->connection->get_article_list($category->{'.count_id'},$this->show, $this->from,'','',$this->search, '',urldecode($this->parameters));    
       
        //Grab all the article ids
        $total = 0;
        foreach ($result as $row) {
          $article_ids[$count]=$row->{"article.id"};
          $total = $row->{"article.row_count"};
          $count++;
        }

        //If we've got more than zero articles
        if (sizeof($result)!=0) { 

          //Go through each article id
          for($i=0;$i<sizeof($article_ids);$i++) {
            
             //Go through each part on the page
             foreach ($content as $content_part) {

               //If it's content
              if (strpos($content_part,"content")) { 
            
                //If it's search content we need to pass the search term too.
                if(isset($_GET["search"])) {
                   $search = $_GET["search"]; 
                 }

                 //Now pass the article contents (retrieved by id) and merge it with the template
                 $this->parseTemplate($this->connection->get_article_by_id($article_ids[$i], $search), $content_part);

              } else {
                 
                //Otherwise, it's not article content just pull the page part template we need instead
                $this->getPart($content_part,$article_ids[$i]);
              }
            }
          }
 
          //After displaying the list of articles add the paging, if needed
          echo (create_pagination($total,$this->show,$this->from,$this->search));
          
        } else {

          //There were zero articles returned by our query.
          echo "No articles found";
        }
      }
    }
  }

  public function getPart($part, $param="") {
    $user_id="0"; 
    if (isset($_SESSION["user2"])) {
      $so = $_SESSION["user2"];
      $user_object = unserialize(base64_decode($so));
      $auth = $user_object->getAuthenticated(); 
    }
    if (isset($auth)) {
       $user_id = $auth;
    } 
    switch($part) {
      case "like":   
        $this->parseTemplate($this->connection->get_all_likes($user_id,$param), "like_content");
        break;
      case "author":
        $this->parseTemplate($this->connection->get_author_name($param),"author_content");
        break;
      case "menu":
        $this->parseTemplate($this->connection->get_category_list($param),"menu_content");
        break;
      default:
        include("templates/".$part.".php");     
        break;
    }
  }

public function parseTemplate($recordset,$prefix) {
  $root="http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12/";
  $string = file_get_contents($root. "/classes/templates/".$prefix.".php"); 
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
