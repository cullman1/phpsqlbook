<?php 
require_once('user.php');
require_once('articlesummary.php');
require_once('articlelist.php');
require_once('category.php');
require_once('categorylist.php');
require_once('commentlist.php');
require_once('comment.php');
require_once('validate.php');
require_once('registry.php');
require_once('database.php');
include('../includes/functions.php');

class Layout {
  private $registry;
  private $server;
  private $category;
  private $item;
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

  public function __construct($server, $category, $item) {
    $this->registry = Registry::instance();
    $this->server = $server;
    $this->category = $category;
    $this->item = $item;
    $this->registry->set('database',new Database());
    $this->database = $this->registry->get('database');  
    $this->connection =  $this->database->connection;
        $this->checkURL();
    $this->createPageStructure();
    $this->assemblePage();
  }

  public function createPageStructure() { 
    $this->show =   ( isset($_GET['show'])   ? $_GET['show']       : '5');
    $this->from =   ( isset($_GET['from'])   ? $_GET['from']       : '0');
    $this->search = ( isset($_GET['search']) ? $_GET['search']     : '' );
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
        if ($this->item=="view") {
          $this->single_templates = array("header","menu","login","search","profile_status","footer");
        } else {
          $this->single_templates = array("header","menu","login","search","profile_update","footer");
        }             
        break;
      case "search":
      default:
        $this->single_templates = array("header", "menu",  "login", "search","article","footer");
        $this->repeating_templates = array("main_content","like");
        break;     
    }
  }

  public function checkURL() { 
      switch($this->item) {
        case "logout":
          submit_logout();
          break;     
        case "likes":
          submitLike();
          break;
        case "add_comment":
          if (!isset($_SESSION["login"])) {
            header('Location: /phpsqlbook/login');
          } else {   
            $comment = new Comment(0, $_GET["id"], get_user_from_session(), '', $_POST["comment"],'', $_GET["reply"],0);
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
    $category = new Category($this->category);
    //Get all articles
    $articlesList = new ArticleList("generic", $this->getArticles($category->id, $this->show, $this->from, '', '' ,$this->search, '', str_replace('-',' ',$this->item)));
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

  public function getHTMLTemplate($template, $id="") {
      $userId=get_user_from_session(); 
    switch($template) {
      case "like":   
          $like = new Like($id, $userId);
          $like->setTotal($id);
          $like->setLiked($id, $userId);
        $this->mergeData($like,"like_content");
        break;
      case "author":
          $user = getUserByArticleId($this->connection, $id);
        $this->mergeData($user,"author_content");
        break;
      case "menu":
          $categorylist = new CategoryList(getCategoryList($this->connection,$id));
        foreach($categorylist->categories as $category) {
          $this->mergeData($category,"menu_content");
        }
        break;
      case "comments":
          $comments = new CommentList(getCommentsById($this->connection, $id));
        if ($comments->commentCount==0) {
             $comment = getBlankComment($this->connection);
             $comments = $comments->add($comment->{".new_id"},$id,'','', '','');
        }
        display_comments2($comments,$comments->commentCount);
        break;   
      default:
        include("templates/".$template.".php");     
        break;
    }
  }

  function getArticles($category = 0, $show, $from, $sort='', $dir='ASC', $search = '', $author_id='0', $name='') {
    //search list
    $list = null;
    if ((!empty($search)) || ($author_id > 0)) {  //search results
     $this->articlesCount = count(get_articles_by_search('', '', $sort='', $dir='ASC', $search, $author_id));
     $list = get_articles_by_search($show, $from, $sort='', $dir='ASC', $search, $author_id);
    } else {
      $this->articlesCount = count(get_articles_by_category('', '', $sort='', $dir='ASC', $category, $name));
      $list =  get_articles_by_category($show, $from, $sort='', $dir='ASC', $category, $name);
    }
    return $list;
}

public function mergeData($data, $file_name) {
  $template = file_get_contents("http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12/classes/templates/".$file_name.".php"); 
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $template, $matches);
  $template = field_replace($template, $matches[0], $data);  
  echo $template;             
}

} ?>
