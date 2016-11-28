<?php 
require_once('user.php');
require_once('articlesummary.php');
require_once('category.php');
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
        if ($this->parameters=="view") {
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
  $articles = array();
  $count = 0;
  //For each section of the page
  foreach ($content as $content_part) {
    //If this is a part that contains content
    if (strpos($content_part,"content")) {   
      //Get the category
      $category = new Category($this->connection, $this->category);    
      //Get all articles
       $result = $category->getArticlesByID($this->connection, $category->id, $this->show, $this->from, '', '' ,$this->search, '', str_replace('-',' ',$this->parameters));
      //Grab all the article ids
      foreach ($result as $row) {
        $article = new ArticleSummary($this->connection,  $row->{"article.id"},  $row->{"article.title"},  $row->{"article.content"}, $row->{"article.published"}, $row->{"article.user_id"},$row->{"category.template"},$row->{"category.name"});
        $articles[$count] =$article;
        $count++;
      }
      //If we've got more than zero articles
      if (sizeof($result)!=0) {        
        //Loop through each article id             
        for($i=0; $i<sizeof($articles); $i++) {  
          //Loop through each article part
          foreach ($content as $content_part) {     
             //If the article part is content
             if (strpos($content_part,"content")) { 
               //Now pass the article contents and merge it with the template
               $this->mergeTemplate($articles[$i], $content_part);
               //$this->parseTemplate($this->connection->get_article_by_id($articles[$i]->{'id'}, $this->search), $content_part);
             } else {
               //Otherwise, if it's not article content pull the page part template instead
               $this->getPart($content_part,$articles[$i]->{'id'}, $articles[$i]);
              }
            }
          }
          //After displaying the list of articles add the paging, if needed
          echo (create_pagination($category->articleCount,$this->show,$this->from,$this->search));
        } else { 
          //There were zero articles returned by our query.
          echo "</nav><div>No articles found</div>";
        }
      }
    }
  }

  public function getPart($part, $param="",$object="") {
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
        $comments = $object->getComments();
        $comment_count =  count($comments);
        if ($comment_count==0) {
             $comments = $object->getCommentHeader();
             $comments[0]->{'comments.article_id'} = $object->id;  
             $comments[0]->{"comments.id"} = $comments[0]->{".new_id"};  
        }
        display_comments($comments,$comment_count);   
        break;   
      default:
        include("templates/".$part.".php");     
        break;
     /*  $total =   $this->get_article_comments_count($articleid);

        $result = $this->connection->get_article_comments($param);  
        }
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
        display_comments2($result, $this->counter, $this->indent); */


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

public function mergeTemplate($data,$prefix) {
  $template = file_get_contents("http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12/classes/templates/".$prefix.".php"); 
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $template, $matches);
  $template = field_replace($template, $matches[0],$data);  
  echo $template;             
}


} ?>
