<?php 
require_once('user.php');
require_once('validate.php');
include('../includes/functions.php');

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
  private $counter;
  private $indent;

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
        $this->page_html = array("header","menu","login_bar","search","login_form","footer");
        break;
      case "register":
        $this->page_html = array("header","menu","search","register_form","footer");
        break;
      case "Contact":
      case "About":
        $this->page_html = array("header", "menu", "login_bar", "search","article","footer");
        $this->content_html = array("no_date_content");
        break;
      case "profile":
        if ($this->parameters=="status") {
          $this->page_html = array("header","menu","login_bar","search","profile_status","footer");
        } else {
          $this->page_html = array("header","menu","login_bar","search","profile_update","footer");
        }             
        break;
      case "search":
      default:
        $this->page_html = array("header", "menu",  "login_bar", "search","article","footer");
        $this->content_html = array("main_content", "author", "like", "comments");
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
        case "add_comment":
          add_comment($this->connection, $_GET["id"], $_GET["comment"]);
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
  $count = 0;
  
  //For each section of the page
  foreach ($content as $content_part) {
    //If this is a part that contains content
    if (strpos($content_part,"content")) {   
      //Get the category
      $category = $this->connection->get_category_by_name($this->category);    
      //Get all articles
      $result = $this->connection->get_article_list($category->{'.count_id'}, $this->show, 
      $this->from, '', '' ,$this->search, '', str_replace('-',' ',$this->parameters));
      //Grab all the article ids
      $total = 0;
      foreach ($result as $row) {
        $article_ids[$count] = $row->{"article.id"};
        $total = $row->{"article.row_count"};
        $count++;
      }
      //If we've got more than zero articles
      if (sizeof($result)!=0) {        
        //Loop through each article id             
        for($i=0; $i<sizeof($article_ids); $i++) {  
          //Loop through each article part
          foreach ($content as $content_part) {     
             //If the article part is content
             if (strpos($content_part,"content")) { 
               //Now pass the article contents and merge it with the template
               $this->parseTemplate($this->connection->get_article_by_id($article_ids[$i], $this->search), $content_part);
             } else {
               //Otherwise, if it's not article content pull the page part template instead
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
    $user_id=get_user_from_session(); 
    switch($part) {
      case "like":   
        $this->parseTemplate($this->connection->get_all_likes($user_id, $param), "like_content");
        break;
      case "author":
        $this->parseTemplate($this->connection->get_author_name($param),"author_content");
        break;
      case "menu":
        $this->parseTemplate($this->connection->get_category_list($param),"menu_content");
        break;
      case "comments":
        $result = $this->connection->get_article_comments($param);  
        $this->indent = 0;
        $new = array();  
        $nestedcomments_row = array();
        foreach ($result as $row) {
          $nestedcomments_row[] = $row;
          $this->counter = $row->{'.Total'};
        }
        foreach ($nestedcomments_row as $branch) {
          $new[$branch->{'comments.repliedto_id'}][]=$branch;             
        }
        if (isset($new[0])) {
          $result = create_tree($new, $new[0]); 
        } 
        display_comments2($result, $this->counter, $this->indent);
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
