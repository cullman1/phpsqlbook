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
    }
    
    public function assemblePage()
    {     
        switch( $this->controller)
        {
            case "article": 
                $this->page_structure = array("header","login_bar", "search", "menu","article","footer");
                $this->content_structure = array("content", "author", "like", "comments");
                break;
            case "admin":
                $this->page_structure = array("header", "menu","article","footer");
                $this->content_structure = array("content");
                break;       
        }
        
        foreach($this->page_structure as $part) {
            if ($part == "article") {
                if (isset($_GET["search"])) {
                    $part="search";    
                }
                $this->registry->set('LayoutTemplate', new LayoutTemplate($this->controller, $this->action, $this->parameters, $this->pdo ));  
                $layouttemplate = $this->registry->get('LayoutTemplate');
                if ($this->parameters[0]!="" && $part!="search") {
                    $layouttemplate->getArticle($part, $this->content_structure, "single" );   
                } else if ($part=="search") {
                    $layouttemplate->getArticle($part, $this->content_structure, "search" );  
                } else {
                    $layouttemplate->getArticle($part, $this->content_structure, "multiple" );  
                }
            }
            else {
                $this->registry->set('LayoutTemplate', new LayoutTemplate($this->controller, $this->action, $this->parameters, $this->pdo ));  
                $layouttemplate = $this->registry->get('LayoutTemplate');
                $layouttemplate->getPart($part);     
            }
        }
    }
}
?>
