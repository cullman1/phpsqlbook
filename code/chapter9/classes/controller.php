<?php
require_once('../classes/registry.php');
require_once('../classes/db-handler.php');
require_once('../classes/layout-template.php');

class Controller {
    private $registry;
    private $controller;
    private $action;
    private $page_structure;
    
    public function __construct($controller, $action, $parameters, $pdo) {
        $this->registry = Registry::instance();
        $this->controller=$controller;
        $this->action=$action;
        $this->parameters=$parameters;
        $this->pdo = $pdo;
        $this->page_structure = array("header","search", "menu","article","footer");
        $this->content_structure = array("content","comments","like");
    }
    
    public function assemblePage()
    {
        if (isset($_GET["search"])) {
            $this->controller="search"; 
        }
        foreach($this->page_structure as $part) {
         
            if ($part == "article") {
                if (isset($_GET["search"])) {
                    $this->controller="search"; 
                }
                $this->getArticle($part);   
            }
            else {
                 $this->getPart($part);     
            }
        }
    }
    
    public function getPart($part)
    {
        $controller_modifier = $this->controller."_";
        if ($part=="menu" || $part=="search")
        {
            $controller_modifier = "";
        }
        require_once ("templates/".$controller_modifier.$part.".php");
    }
    
    public function getArticle($part)
    {
        $this->getContent();
    }
        
    public function getContent() {
        $this->registry->set('DbHandler', new DbHandler($this->pdo));  
        $dbhandler = $this->registry->get('DbHandler');
        $this->registry->set('LayoutTemplate', new LayoutTemplate($this->pdo));  
        $layouttemplate = $this->registry->get('LayoutTemplate');
       
        $category_modifier ="";
        switch ($this->controller) {
            case "article": 
                if($this->parameters[0]=="") {
                    $recordset = $dbhandler->getArticleList($this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $layouttemplate->parseTemplate($dbhandler->getArticleList($this->pdo),  $category_modifier, $this->controller, $this->pdo);
                  
                }
                else if(is_numeric($this->parameters[0])) {
                    $recordset = $dbhandler->getArticleById($this->parameters, $this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $layouttemplate->parseTemplate($dbhandler->getArticleById($this->parameters, $this->pdo), $category_modifier, $this->controller, $this->pdo);
                }
                else {
                    $recordset = $dbhandler->getArticleByName($this->parameters, $this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $layouttemplate->parseTemplate($dbhandler->getArticleByName($this->parameters, $this->pdo), $category_modifier, $this->controller, $this->pdo);
                }
                break;
            case "search":
                $recordset = $dbhandler->getSearchResults($this->pdo);
                $layouttemplate->parseTemplate($dbhandler->getSearchResults($this->pdo), "",$this->controller, $this->pdo);
                $this->controller = "article";
                break;
        } 
    }
}
?>
