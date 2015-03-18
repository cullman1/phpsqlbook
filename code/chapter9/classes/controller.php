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
       
        
       
        foreach($this->page_structure as $part) {
         
            if ($part == "article") {
                if (isset($_GET["search"])) {
                    $part="search"; 
                    $this->controller = "search";
                  
                }
                $this->registry->set('LayoutTemplate', new LayoutTemplate($this->controller, $this->action, $this->parameters, $this->pdo ));  
                $layouttemplate = $this->registry->get('LayoutTemplate');
                $layouttemplate->getArticle($part);   
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
