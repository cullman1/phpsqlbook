<?php class UrlRewriter {
 private $category;
 private $item;  
   private $controller;
 private $parameters="";
 private $registry;
 private $article_content;
    
 public function __construct() { 
    $this->registry = Registry::instance();
    $this->parseUrl(1); 
    $this->getContent($this->item); 
  }

  private function parseUrl($number_of_parts) {
    $parts=trim(parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH),"/");
    $url_parts = explode("/", $parts, $number_of_parts+3);
    $this->category = $url_parts[$number_of_parts];
    if (isset($url_parts[$number_of_parts+1])) {
    $this->item =  $url_parts[$number_of_parts+1];
    } else {
    $this->item = ""; 
}
} 

public function routeRequest() {
 $this->registry->set('Controller', new Controller($this->controller,$this->category,$this->item));
  $control = $this->registry->get('Controller');
 $control->createPageStructure();
}

public function getContent($title) { 
 $db = $this->registry->get('database'); 
 $this->article_content = $db->getArticleByName($title);
}

} ?>
