<?php
require_once('../classes/registry.php');
require_once('../classes/user.php');

class LayoutTemplate {
    private $registry;
    private $controller;
    private $pdo;
    public function __construct($controller, $action, $parameters ,$pdo) {
        $this->registry = Registry::instance();
        $this->pdo = $pdo;
        $this->controller = $controller;
        $this->action = $action;
        $this->parameters = $parameters;
        $this->registry->set('DbHandler', new DbHandler($this->pdo));  
    }
    
    public function getArticle($part, $content_structure, $multiplesingle)
    {
        $article_ids = array();
        if ($multiplesingle=="multiple") {
            $dbhandler = $this->registry->get('DbHandler');
            $recordset = $dbhandler->getArticleList($this->pdo);   
            
            $count=0;
            while ($row=$recordset->fetch()) {
                $article_ids[$count]=$row["article.article_id"];
                $count++;
            }
        } else {
            $article_ids[0]=$this->parameters[0];
        }
           
        for($i=0;$i<sizeof($article_ids);$i++) {
            foreach ($content_structure as $content_part) {
                if ($content_part == "content") {
                    $this->getContent($article_ids[$i]);
                }
                else {
                    if ($this->parameters[0]=="" ||is_numeric($this->parameters[0])) {
                        $this->getPart($content_part, $article_ids[$i]);
                    }
                    else {
                        $this->getPart($content_part, $this->parameters[0]);
                    }
                }
            }
        }
        
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
            $controller_modifier = "";
            break;
         case "comments":
            $controller_modifier = "";
            $dbhandler = $this->registry->get('DbHandler');
            $recordset2 = $dbhandler->getArticleComments($this->pdo, $param);   
            $this->writeComments($recordset2);
            break;
         case "like":
            $controller_modifier = "";
            $dbhandler = $this->registry->get('DbHandler');        
            $recordset2 = $dbhandler->getLikesTotal($this->pdo, $param);   
            if ($row = $recordset2->fetch()) {
                $_REQUEST["article_id"]=$row["article_like.article_id"];
                $_REQUEST["likes"]=$row[".likes"];
            }
            else {
                $_REQUEST["article_id"]=$param;
                $_REQUEST["likes"]=0;
            }
            if (isset($auth)) {
                $_REQUEST["user_id"] = $auth;
            }
            else {
                $_REQUEST["user_id"] = 0;
            }
            break;
         case "author":
            $controller_modifier = "";
            $dbhandler = $this->registry->get('DbHandler');
            $recordset2 = $dbhandler->getAuthorName($this->pdo, $param);   
            while ($row = $recordset2->fetch()) {
                $_REQUEST["name"]=$row["user.full_name"];
            }
             
            break;
        }
        if ($part!="comments") {
            include ("templates/".$controller_modifier.$part.".php"); 
        }
    }
    
    public function getContent($article_id) { 
        $category_modifier="";
        $dbhandler = $this->registry->get('DbHandler');
        switch ($this->controller) {
            case "article": 
                if(is_numeric($this->parameters[0]) || $this->parameters[0]=="") {
                    $this->parseTemplate($dbhandler->getArticleById($article_id, $this->pdo), $category_modifier, $this->controller, $this->pdo);
                }
                else {
                    $this->parseTemplate($dbhandler->getArticleByName($this->parameters, $this->pdo), $category_modifier, $this->controller, $this->pdo);
                }
                break;
            case "search":   
                $this->parseTemplate($dbhandler->getSearchResults($this->pdo), "",$this->controller, $this->pdo);
                $this->controller = "article";
                break;
        } 
    }
    
    public function parseTemplate($recordset, $category_modifier, $controller, $pdo) {
        //Removes modifier for time being
        if(isset($category_modifier)) {
            $category_modifier = "";
        } 
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter9/classes/templates/".$category_modifier.$controller."_content.php");
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
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter9/classes/templates/comments.php");
        $regex = '#{{(.*?)}}#';
        preg_match_all($regex, $string, $matches);
        $opening_tag = strpos($string, "]]");
        $closing_tag = strpos($string, "]]", $opening_tag+1);    
        $string1= str_replace("[[for]]","", $string);
        $string2= str_replace("[[next]]","", $string1);
        $string3= str_replace("]","", $string2);
        $header_template= substr($string3, 0, $opening_tag);
        $remain = $closing_tag - $opening_tag;
    
        $subset_template2 = array();
        $count=0;
        while ($row = $recordset->fetch()) {  
            $subset_template = substr($string3, $opening_tag+1, $remain-9);
            //header 
            if ($count==0) {
                //Get out content of string, replace with $row
                foreach($matches[0] as $value) {           
                    $replace= str_replace("{{","", $value);
                    $replace= str_replace("}}","", $replace);
                    $header_template = str_replace($value, $row[$replace], $header_template);      
                }  
                echo $header_template;
            } 
            //content
            preg_match_all($regex, $subset_template, $inner_matches);
            foreach($inner_matches[0] as $value) {   
                $replace= str_replace("{{","", $value);
                $replace= str_replace("}}","", $replace);
                //echo "Value: " . $value . " Row Replace: ". $row[$replace] . "<br/>";
                $subset_template = str_replace($value, $row[$replace], $subset_template);    
                $subset_template2[$count] = $subset_template;
            }
   

            $count++;
        }
        for ($i=0;$i<$count;$i++)
        {
            echo $subset_template2[$i];
        }
        
        echo "</div></div></div>";
    }
}
?>