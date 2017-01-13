<?php
class UrlRewriter {
  private $server;
  private $category;  
  private $item=""; 

  public function __construct() { $this->parseUrl(0); }

  private function parseUrl($offset) {
  $parts = trim( parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH),"/");
  $url_parts = explode("/", $parts, $offset+3);
  $this->server = $url_parts[$offset];
  $this->category = $url_parts[$offset+1];
  if (isset($url_parts[$offset+2])) {
    $this->item =  $url_parts[$offset+2];
  } else {
    $this->item = ""; 
  }
  }
} 
?>