<?php
require_once('../classes/search.php');
require_once('../classes/registry.php');
require_once('../classes/db-handler.php');
require_once('../classes/layout-template.php');

class Controller {
    private $registry;
    private $controller;
    
    public function __construct(array $widgets, $controller, $page, $parameters, $pdo) {
        $this->pdo = $pdo;
        $this->registry = Registry::instance();
        $this->controller=$controller;
        $this->page=$page;
        $this->parameters=$parameters;
        foreach($widgets as $widget) {
            $this->registry->set($widget, new $widget($pdo));
        }
    }
    
    public function getPart($part)
    {
        require_once ("templates/".$this->controller."_".$part.".php");
    }
        
    public function getSearch() {
         $search = $this->registry->get("Search");
         if (isset($_GET["search"])) {
             $search->getSearchResults($this->pdo);
         }
         $search->getSearchTemplate();
    }
     
    public function getContent() {
        $this->registry->set('DbHandler', new DbHandler($this->pdo));  
        $dbhandler = $this->registry->get('DbHandler');
        $this->registry->set('LayoutTemplate', new LayoutTemplate($this->pdo));  
        $layouttemplate = $this->registry->get('LayoutTemplate');
        $category_modifier ="";
        switch ($this->controller) {
            case "article": 
                if(empty($this->action)) {
                    $recordset = $dbhandler->getArticleList($this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $layouttemplate->parseTemplate($dbhandler->getArticleList($this->pdo), $category_modifier);
                }
                else if(is_numeric($this->parameters[0])) {
                    $recordset = $dbhandler->getArticleById($this->parameters, $this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $layouttemplate->parseTemplate($dbhandler->getArticleById($this->parameters, $this->pdo), $category_modifier);
                }
                else {
                    $recordset = $dbhandler->getArticleByName($this->parameters, $this->pdo);
                    while ($row = $recordset->fetch()) {
                        $category_modifier = $row["category.category_name"];
                    }
                    $layouttemplate->parseTemplate($dbhandler->getArticleByName($this->parameters, $this->pdo), $category_modifier);
                }
                break;
        } 
    }
}
?>
