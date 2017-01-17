<?php
require_once('user.php');       //include from chapter XX
require_once('validate.php');   //include from chapter XX
require_once('articlesummary.php');    // from chapter XX
require_once('articlelist.php');       // from chapter XX
require_once('category.php');          // from chapter XX
require_once('categorylist.php');      // from chapter XX
require_once('like.php');      // from chapter XX
require_once('../includes/functions.php'); //include
require_once('commentlist.php');  //Add references to the new objects
require_once('comment.php');

class Layout {
    private $registry;
    private $server;
    private $category;
    private $item;
    private $connection;
    private $single_templates = array();
    private $repeating_templates = array();
    private $error = array('id'=>'', 'title'=>'', 
    'article'=>'','email'=>'', 'password'=>'','date'=>'',
    'firstName'=>'','lastName'=>'', 'image'=>'');
    private $from;
    private $show;
    private $search;

    public function __construct($server, $category, $item) {
        $this->registry = Registry::instance();
        $this->registry->set('database',new Database());
        $this->database = $this->registry->get('database');  
        $this->connection =  $this->database->connection; 
        $this->server = $server;
        $this->category = $category;
        $this->item = $item;
        $this->checkURL();
        $this->createPageStructure();
        $this->assemblePage();
    }

    function getArticles($category = 0, $show, $from, $sort='', $dir='ASC', $search = '', $author_id='0', $name='') {
        //search list
        $list = null;
        if ((!empty($search)) || ($author_id > 0)) {  
            //search results
            $this->articlesCount = count(get_articles_by_search('', '', $sort='', $dir='ASC', 
                                                                $search, $author_id));
            $list = get_articles_by_search($show, $from, $sort='', $dir='ASC', $search, $author_id);
        } else {
            $this->articlesCount = count(get_articles_by_category('', '', $sort='', $dir='ASC',  
                                                                  $category, $name));
            $list = get_articles_by_category($show, $from, $sort='', $dir='ASC', $category, $name);
        }
        return $list;
    }

    public function createPageStructure() { 
        $this->show   = ( isset($_GET['show'])    ? $_GET['show']   : '5' );
        $this->from   =  ( isset($_GET['from'])   ? $_GET['from']   : '0' );
        $this->search =  ( isset($_GET['search']) ? $_GET['search'] : '' );
        switch($this->category) {
            case "login":
                $this->single_templates = array("header","menu","search","login_form","footer");
                break;
            case "register":
                $this->single_templates = array("header","menu","search","register_form", "footer");
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
                $this->single_templates = array("header","menu","login","search","article","footer");
                $this->repeating_templates = array("main_content", "author", "like", "comments");
                break;     
        }
    }

    public function checkURL() { 
  
        switch($this->item) {
         case "likes":
             submit_like();
          break; 
            case "logout":
                submit_logout();
                break;  
            case "add_comment":
                if (!isset($_SESSION["user2"])) {
                    header('Location: /phpsqlbook/login');
                } else {   
                    $comment = new Comment(0, $_GET["id"], 
                               get_user_from_session(), '', 
                               $_POST["comment"], '', $_GET["reply"]);
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

    public function getHTMLTemplate($template,$id=""){
        $userId = get_user_from_session(); 
        switch($template) {
            case "menu":
                $categorylist = new CategoryList(   
                 getCategoryList($id));
                foreach($categorylist->categories as $category) {
                    $this->mergeData($category,"menu_content");
                }
                break;
            case "author":
                $user = getUserByArticleId($id);
                $this->mergeData($user, "author_content");
                break;
            case "like":   
                $like = new Like($id, $userId);
                $like->setTotal($id);
                $like->setLiked($id, $userId);
                $this->mergeData($like, "like_content");
                break;
            case "comments":
                //Gets the list of comments
                $comments = new CommentList(get_comments_by_id($id));
                //If there are no comments
                if ($comments->commentCount==0) {
                    //We still need to create a form for the article so people can comment on it
                    $comment = get_blank_comment();
                    $comments = $comments->add($comment->{".new_id"}, $id, '', '', '', '', '','');
                }             
                //Now display the comments after an article.
                display_comments($comments,$comments->commentCount); 
                break;
            default:
                include("templates/".$template.".php");     
                break;
        }
    }

    public function assembleArticles($templates) {
        //Get the category
        $category = new Category($this->category);
        //Get all articles
        $articlesList = new ArticleList("generic",
         $this->getArticles($category->id, $this->show, 
                         $this->from, '', '' ,$this->search, '', 
                         str_replace('-',' ',$this->item)));
        //If we've got more than zero articles
        if (sizeof($articlesList->articles)!=0) {              
            //Loop through each article id
            for($i=0; $i<sizeof($articlesList->articles); $i++) {
                //Loop through each template
                foreach ($templates as $repeating_template) {     
                    //If the template has article data
                    if (strpos($repeating_template,"content")) { 
                        //Now merge data with the article template
                        $this->mergeData($articlesList->articles[$i], 
                                         $repeating_template);
                    } else {
                        //Otherwise, no data,get only HTML template
                        $this->getHTMLTemplate($repeating_template, 
                               $articlesList->articles[$i]->{'id'});
                    }
                }
            }
            //After showing list of articles add paging, if needed
            echo (create_pagination($this->articlesCount, 
                  $this->show, $this->from, $this->search));
        } else { 
            //There were zero articles returned by our query.
            echo "</nav><div>No articles found</div>";
        }
    }

    public function mergeData($data, $file_name) {
        $template = file_get_contents("http://". 
        $_SERVER['HTTP_HOST']. "/phpsqlbook/code/chapter_12/classes/templates/".$file_name.".php"); 
        $regex = '#{{(.*?)}}#';
        preg_match_all($regex, $template, $matches);
        $template = field_replace($template,$matches[0],$data);
        echo $template;             
    }
}
?>