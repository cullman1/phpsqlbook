<?php
require_once('../classes/registry.php');
require_once('../classes/user.php');

class LayoutTemplate {
    private $registry;
    private $controller;
    private $pdo;
    private $counter;
    private $indent;
    public function __construct($controller, $action, $parameters ,$pdo) {
        $this->registry = Registry::instance();
        $this->pdo = $pdo;
        $this->controller = $controller;
        $this->action = $action;
        $this->parameters = $parameters;
        $this->registry->set('DbHandler', new DbHandler($this->pdo));  
    }
    
    public function createTree(&$list, $parent){
        $tree = array();
        foreach ((array)$parent as $reply) {
            if (isset($list[$reply['comments.comments_id']])) {
                $reply['children'] = $this->createTree($list, $list[$reply['comments.comments_id']]);
            }
            $tree[] = $reply;
        } 
        return $tree;
    }
     
    public function getPart($part, $param="")
    {
        if (isset($_SESSION["user2"])) { 
            $so = $_SESSION["user2"];
            $user_object = unserialize($so);
            $auth = $user_object->getAuthenticated();
        }
        $controller_modifier = $this->controller."_";
        $querystring="";
        switch($part) {
         case "menu":
         case "search":
         case "login_bar":
            $controller_modifier = "";
            break;
         case "comments":
            $controller_modifier = "";
            $dbhandler = $this->registry->get('DbHandler');
            $select_comments_result = $dbhandler->getArticleComments($this->pdo, $param);   
            $new = array();
            unset($new);
            $select_nestedcomments_row = array();
            while($select_comments_row =$select_comments_result->fetch()) {
                $select_nestedcomments_row[] = $select_comments_row;
            }  
            $counter=0;
            foreach ($select_nestedcomments_row as $branch) {
                $counter++;
                $new[$branch['comments.comment_repliedto_id']][] = $branch;
            }
            $tree = $this->createTree($new, $new[0]); 
            $this->writeComments($tree);
            break;
         case "like":
            $controller_modifier = "";
            $dbhandler = $this->registry->get('DbHandler');   
            if (isset($auth)) {
                $user_id = $auth;
            } else {
                $user_id  = "0";
            }
                $this->parseTemplate($dbhandler->getAllLikes($this->pdo,  $user_id , $param), "", "like", $this->pdo);
            break;
         case "author":
            $controller_modifier = "";
            $dbhandler = $this->registry->get('DbHandler'); 
            $this->parseTemplate($dbhandler->getAuthorName($this->pdo, $param), "", "author", $this->pdo);
            break;
        }
        if ($part!="comments" && $part!="author" && $part!="like") {
            include ("templates/".$controller_modifier.$part.".php"); 
        }   
    }
    
    public function getContent($article_id) { 
        $category_modifier="";
        $dbhandler = $this->registry->get('DbHandler');  
        if(is_numeric($this->parameters[0]) || $this->parameters[0]=="" || isset($_REQUEST["search"] )) {
            $this->parseTemplate($dbhandler->getArticleById($this->pdo, $article_id), $category_modifier, $this->controller, $this->pdo);
        }
        else {        
            $this->parseTemplate($dbhandler->getArticleByName($this->pdo, $this->parameters ), $category_modifier, $this->controller, $this->pdo);
        }
    }
    
    public function parseTemplate($recordset, $category_modifier, $controller, $pdo) {
        //Removes modifier for time being
        if(isset($category_modifier)) {
            $category_modifier = "";
        } 
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter_12/classes/templates/".$category_modifier.$controller."_content.php");
        $regex = '#{{(.*?)}}#';
        preg_match_all($regex, $string, $matches);
        while($row = $recordset->fetch())
        {
            $template=$string;
            //Get out content of string, replace with $row
            foreach($matches[0] as $value) {           
                $replace= str_replace("{{","", $value);
                $replace= str_replace("}}","", $replace);
            
                $template = str_replace($value, $row[$replace], $template);  
            }  
            echo $template;
        }
    }
    
    public function writeComments($recordset)
    {   
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter_12/classes/templates/comments.php");
        $regex = '#{{(.*?)}}#';
        preg_match_all($regex, $string, $matches);
        $opening_tag = strpos($string, "]]");
        $closing_tag = strpos($string, "]]", $opening_tag+1);    
        $string1= str_replace("[[for]]","", $string);
        $string2= str_replace("[[next]]","", $string1);
        $string3= str_replace("]","", $string2);
        $header_template= substr($string3, 0, $opening_tag);
        $remain = $closing_tag - $opening_tag;
        $combined_comments = array();
        $this->counter=0;
        $this->indent=0;
        foreach ($recordset as $row) {
            $subset_template = substr($string3, $opening_tag+1, $remain-9);
            //header 
            if ($this->counter==0) {
                //Get out content of string, replace with $row
                foreach($matches[0] as $value) {           
                    $replace= str_replace("{{","", $value);
                    $replace= str_replace("}}","", $replace);
                    $header_template = str_replace($value, $row[$replace], $header_template);      
                }  
                echo $header_template;
            }           
            $combined_comments = $this->recursiveCheck($regex, $subset_template, $row, $combined_comments);
        }
        for ($i=0;$i<$this->counter;$i++) {
            echo $combined_comments[$i];
        }
        echo "</div></div></div>";
    }
    
    public function recursiveCheck($regex, $subset_template, $row, $combine_comments)
    {
        if (isset($row['children'])) {       
            $combine_comments = $this->tagReplace($regex, $subset_template, $row, $combine_comments);
            $this->counter++;
            $this->indent+=20;
            foreach ($row['children'] as $row2) {     
                $combine_comments = $this->recursiveCheck($regex, $subset_template,  $row2, $combine_comments);
            }      
        }
        else {      
            $combine_comments = $this->tagReplace($regex, $subset_template,  $row, $combine_comments);
            $this->counter++;
            $this->indent=0;
        } 
        return $combine_comments;
    } 
    
    public function tagReplace($regex, $subset_template, $row, $combined_comments) {
        preg_match_all($regex, $subset_template, $inner_matches);
        foreach($inner_matches[0] as $value) {   
            $replace= str_replace("{{","", $value);
            $replace= str_replace("}}","", $replace);
            $subset_template = str_replace($value, $row[$replace], $subset_template);    
            if ($this->indent>0) { 
                $combined_comments[$this->counter] = "<div style='margin-left:".$this->indent."px'>".$subset_template."</div>"; 
            } 
            else {
                $combined_comments[$this->counter] = $subset_template;
            }
        }
        return $combined_comments;
    }
}
?>