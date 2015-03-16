<?php
require_once('../classes/registry.php');
require_once('../classes/db-handler.php');
require_once('../classes/layout-template.php');

class Controller {
    private $registry;
    private $controller;
    private $action;
    public function __construct(array $widgets, $controller, $action, $parameters, $pdo) {
        $this->registry = Registry::instance();
        $this->controller=$controller;
        $this->action=$action;
        $this->parameters=$parameters;
        $this->pdo = $pdo;
    }
    
    public function assemblePage(array $parts)
    {
        foreach($parts as $part) {
            if ($part == "content") {
                if (isset($_GET["search"])) {
                    $this->controller="search"; 
                }
                $this->getContent();   
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
        
    public function getContent() {
        $this->registry->set('DbHandler', new DbHandler($this->pdo));  
        $dbhandler = $this->registry->get('DbHandler');
        $this->registry->set('LayoutTemplate', new LayoutTemplate($this->pdo));  
        $layouttemplate = $this->registry->get('LayoutTemplate');
       
        $category_modifier ="";
        switch ($this->controller) {
            case "article": 
                if(!(isset($this->parameters[0]))) {
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
