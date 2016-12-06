<?php 
require_once('user.php');
require_once('articlesummary.php');
require_once('articlelist.php');
require_once('category.php');
require_once('categorylist.php');
require_once('commentlist.php');
require_once('comment.php');
require_once('validate.php');
include('../includes/functions.php');

class Layout {
  private $registry;
  private $server;
  private $category;
  private $parameters;
  private $connection;
  private $single_templates = array();
  private $repeating_templates = array();
  private $search;
  private $error = array('id'=>'', 'title'=>'','article'=>'','template'=>'','email'=>'','password'=>'','mimetype'=>'','date'=>'','datetime'=>'','firstName'=>'','lastName'=>'', 'image'=>'');
  private $from;
  private $show;
  private $counter;
  private $indent;
  private $articlesCount;

  public function __construct($server, $category, $parameters) {
    $this->registry = Registry::instance();
    $this->server = $server;
    $this->category = $category;
    $this->parameters = $parameters;
    $this->registry->set('database',new Database());
    $this->database = $this->registry->get('database');  
    $this->connection =  $this->database->connection;
  }

  public function createPageStructure() { 
    $this->show = ( isset($_GET['show'])     ? $_GET['show']       : '5' );
    $this->from =  ( isset($_GET['from'])       ? $_GET['from']       : '0' );
    $this->search =  ( isset($_GET['search'])       ? $_GET['search']       : '' );
    switch($this->category) {
      case "login":
        $this->single_templates = array("header","menu","login","search","login_form","footer");
        break;
      case "register":
        $this->single_templates = array("header","menu","search","register_form","footer");
        break;
      case "Contact":
      case "About":
        $this->single_templates = array("header", "menu", "login", "search","article","footer");
        $this->repeating_templates = array("no_date_content");
        break;
      case "profile":
        if ($this->parameters=="view") {
          $this->single_templates = array("header","menu","login","search","profile_status","footer");
        } else {
          $this->single_templates = array("header","menu","login","search","profile_update","footer");
        }             
        break;
      case "search":
      default:
        $this->single_templates = array("header", "menu",  "login", "search","article","footer");
        $this->repeating_templates = array("main_content", "author", "like", "comments");
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
            if (!isset($_SESSION["user2"])) {
              header('Location: /phpsqlbook/login');
            } else {   
           $user_id = get_user_from_session(); 
           $comment = new Comment('',$_GET["id"],$user_id, '', $_POST["commentText"],'', $_GET["comment"]);
           $comment->create();
           header('Location: '.$_SERVER['HTTP_REFERER']);
  }
          break;	
     }
  }

  public function assemblePage() {
    foreach($this->single_templates as $template_section) { 
       if($template_section == "article") {
         $this->assembleArticles($this->repeating_templates);
       } else {
         $this->getHTMLTemplate($template_section);
       }
    }
  }

  public function assembleArticles($templates) {
    //Get the category
    $this->registry->set('category',new Category($this->category));
    $category = $this->registry->get('category');
    //Get all articles
    $articlesList = new ArticleList("generic", $this->getArticles($this->connection, $category->id, $this->show, $this->from, '', '' ,$this->search, '', str_replace('-',' ',$this->parameters)));
    //If we've got more than zero articles
    if (sizeof($articlesList->articles)!=0) {        
      //Loop through each article id             
      for($i=0; $i<sizeof($articlesList->articles); $i++) {  
        //Loop through each template
        foreach ($templates as $repeating_template) {   
          //If the template contains data
          if (strpos($repeating_template,"content")) { 
            //Pass the article contents and merge it with the article template
            $this->mergeData($articlesList->articles[$i], $repeating_template);
          } else {
           //Otherwise, if article data not required, get HTML template
            $this->getHTMLTemplate($repeating_template,$articlesList->articles[$i]->{'id'});
          }
        }
      }
      //After displaying the list of articles add paging, if needed
      echo (create_pagination($this->articlesCount,$this->show,$this->from,$this->search));
    } else { 
      //There were zero articles returned by our query.
      echo "</nav><div>No articles found</div>";
    }
  }

  public function getHTMLTemplate($template, $param="") {
    $user_id=get_user_from_session(); 
    switch($template) {
      case "like":   
        $likes_list = getAllLikes($this->connection, $user_id, $param);
        foreach($likes_list as $likes) {
          $this->mergeData($likes,"like_content");
        }
        break;
      case "author":
        $user = getUserByArticleId($this->connection, $param);
        $this->mergeData($user,"author_content");
        break;
      case "menu":
        $categorylist = new CategoryList($this->connection, getCategoryList($this->connection,$param));
        foreach($categorylist->categories as $category) {
          $this->mergeData($category,"menu_content");
        }
        break;
      case "comments":
        $comment_list = getCommentsById($this->connection, $param);
        $comment_count =  count($comment_list);
        $comments = new CommentList($comment_list);
        if ($comment_count==0) {
             $comment = getBlankComment($this->connection);
             $comments = $comments->add($comment->{".new_id"},$param,'','', '','');
        }
        display_comments($comments,$comment_count);   
        break;   
      default:
        include("templates/".$template.".php");     
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

  function getArticles($connection, $category = 0, $show, $from, $sort='', $dir='ASC', $search = '', $author_id='0', $name='') {
    //search list
    $articlesList = null;
    if ((!empty($search)) || ($author_id > 0)) {  //search results
     $this->articlesCount = count(getArticlesBySearch($connection,'', '', $sort='', $dir='ASC', $search, $author_id));
     $articlesList = getArticlesBySearch($connection,$show, $from, $sort='', $dir='ASC', $search, $author_id);
    } else {
      $this->articlesCount = count(getArticlesByCategory($connection,'', '', $sort='', $dir='ASC', $category, $name));
      $articlesList =  getArticlesByCategory($connection,$show, $from, $sort='', $dir='ASC', $category, $name);
    }
    return $articlesList;
}

public function mergeData($data, $file_name) {
  $template = file_get_contents("http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12/classes/templates/".$file_name.".php"); 
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $template, $matches);
  $template = field_replace($template, $matches[0], $data);  
  echo $template;             
}

} ?>
