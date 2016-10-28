<?php class UrlRewriter {
 private $category;
 private $item;  
 private $server;
 private $parameters="";
 private $registry;
 private $article_content;
    
 public function __construct() { 
    $this->registry = Registry::instance();
    $this->parseUrl(0); 
  //  $this->getContent($this->item); 
  }

  private function parseUrl($number_of_parts) {
    $parts=trim(parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH),"/");
    $url_parts = explode("/", $parts, $number_of_parts+3);
    $this->server = $url_parts[$number_of_parts];
    $this->category = $url_parts[$number_of_parts+1];
    if (isset($url_parts[$number_of_parts+2])) {
      $this->item =  $url_parts[$number_of_parts+2];
    } else {
      $this->item = ""; 
    }
  } 

  public function routeRequest() {
    $this->registry->set('LayoutTemplate', new LayoutTemplate($this->server,$this->category,$this->item));
    $control = $this->registry->get('LayoutTemplate');
    $control->createPageStructure();
  }

  public function getContent($title) { 
    $db = $this->registry->get('database'); 
    $this->article_content = $db->get_article_by_name($title);
  }

} ?>
