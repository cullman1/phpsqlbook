<?php
require_once('../classes/registry.php');

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
            //$this->getPart("Like");
       
            $this->getPart("comments",$row["article.article_id"]);
            //$this->writeComments($recordset2, "total_");
            //$this->writeComments($recordset2,"");
        }
    }
    
    
    
    public function getPart($part, $param="")
    {
        $controller_modifier = $this->controller."_";
        if ($part=="menu" || $part=="search" ||  $part=="comments") {
            $controller_modifier = "";
        }
        if ($part=="comments") {
            $dbhandler = $this->registry->get('DbHandler');
            $recordset2 = $dbhandler->getArticleComments($this->pdo, $param);   
            $this->writeComments($recordset2, $param);
        }
        else
        {
            require_once ("templates/".$controller_modifier.$part.".php");
        }
    }
    
    public function getArticle($part)
    {
        $this->getContent();
    }
    
    public function getContent() {
     
        $dbhandler = $this->registry->get('DbHandler');
       
        $category_modifier ="";
        switch ($this->controller) {
            case "article": 
                if($this->parameters[0]=="") {
                    $recordset = $dbhandler->getArticleList($this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $this->parseTemplate($dbhandler->getArticleList($this->pdo),  $category_modifier, $this->controller, $this->pdo);
                    
                }
                else if(is_numeric($this->parameters[0])) {
                    $recordset = $dbhandler->getArticleById($this->parameters, $this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $this->parseTemplate($dbhandler->getArticleById($this->parameters, $this->pdo), $category_modifier, $this->controller, $this->pdo);
                }
                else {
                    $recordset = $dbhandler->getArticleByName($this->parameters, $this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $this->parseTemplate($dbhandler->getArticleByName($this->parameters, $this->pdo), $category_modifier, $this->controller, $this->pdo);
                }
                break;
            case "search":
           
                $recordset = $dbhandler->getSearchResults($this->pdo);
                $this->parseTemplate($dbhandler->getSearchResults($this->pdo), "",$this->controller, $this->pdo);
                $this->controller = "article";
                break;
        } 
    }
    
    public function writeComments($recordset, $total)
    {   
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter9/classes/templates/comments.php");
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
}
?>