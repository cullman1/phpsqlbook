<?php class UrlRewriter {
 private $category;
 private $item;  
 private $server;
 private $parameters="";
 private $registry;
    
 public function __construct() { 
    $this->registry = Registry::instance();
    $this->parseUrl(0); 
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
    $this->registry->set('Layout', new Layout($this->server,$this->category,$this->item));
    $control = $this->registry->get('Layout');
    $control->createPageStructure();
  }

} ?>
