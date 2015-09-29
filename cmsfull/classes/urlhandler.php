<?php class UrlHandler {
 private $controller;
 private $action;  
 private $parameters="";
 private $registry;
    
 public function __construct() { 
    $this->registry = Registry::instance();
    $this->parseUrl();  
  }

  private function parseUrl() {
$p=trim(parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH),"/");
 $i=1;
 $url_parts = explode("/", $p, $i+3);
 $controller = $url_parts[$i];
  $action = "";
  $parameters = "";

    if(sizeof($url_parts)==$i+2) {
    if(is_numeric($url_parts[$i+1])) {
      $parameters = $url_parts[$i+1];
      } else {
        $action = $url_parts[$i+1];
        $parameters = $url_parts[$i+1];
      }
    } else if (sizeof($url_parts)==$i+3)  {
      $action = $url_parts[$i+1];
      $parameters = $url_parts[$i+2];
    }
 
  if (isset($controller)) {
    $this->setController($controller);
  }
  if (isset($action)) {
    $this->setAction($action);
  }
  if (isset($parameters)) {
    $this->setParameters(explode("/",$parameters));
  }  
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
public function routeRequest() {
 $this->registry->set('Controller', new Controller($this->controller,$this->action,$this->parameters));
  $control = $this->registry->get('Controller');
 $control->createPageStructure();
 
}

} ?>
