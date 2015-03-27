<?php
class UrlHandler {
    private $parameters="";
    private $registry;
    private $pdo;
    private $controller;
    private $action;
    
    public function __construct($pdo) { 
            $this->registry = Registry::instance();
            $this->pdo = $pdo;
            $this->parseUrl();  
    }       
    
    private function parseUrl() {
        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        $url_parts = explode("/", $path, 3);
        $controller = $url_parts[0];
        $action = "";
        $parameters = "";
        if($controller=="admin") {
            if(sizeof($url_parts)==3) {
                $action = $url_parts[1];
                $parameters = $url_parts[2];
            }
        }
        else { 
            if(sizeof($url_parts)==2) {
                $parameters = $url_parts[1];
            }
        }
        if (isset($controller)) {
            $this->setController($controller);
        }
        if (isset($action)) {
            $this->setAction($action);
        }
        if (isset($parameters)) {
            $this->setParameters(explode("/", $parameters));
        }
        
    }
    
    public function routeRequest() {
        $this->registry->set('Controller', new Controller($this->controller, $this->action, $this->parameters, $this->pdo));
        $control = $this->registry->get('Controller');   
        $control->createPageStructure();
    }
    
    public function setController($controller) {
        $this->controller = $controller; 
    }
    
    public function setAction($action) {
            $this->action = $action;
    }
    
    public function setParameters(array $parameters) {
        $this->parameters = $parameters;   
    }
    
    public function getController() {
        return $this->controller; 
    }
    
    public function getAction() {
        return $this->action; 
    }
    
    public function getParameters() {
        return $this->parameters; 
    }
}
?>