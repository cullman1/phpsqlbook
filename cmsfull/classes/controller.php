<?php 
require_once('../classes/registry.php');
require_once('../classes/dbhandler.php');
require_once('../classes/layouttemplate.php');
class Controller {
  private $registry;
  private $controller;
  private $action;
  private $page_html;
  private $content_html;
  public function __construct($controller, 
   $action, $parameters, $pdo) {
    $this->registry = Registry::instance();
    $this->controller=$controller;
    $this->action=$action;
    $this->parameters=$parameters;
    $this->pdo = $pdo; 
  }

  public function createPageStructure() {     
 switch($this->controller) {
  case "article": 
   $this->page_html = array("header","search", "menu",  "article","footer");
   $this->content_html = array("content", "author");
   break;
  case "admin":
   $this->page_html = array("header","menu","article", "footer");
   $this->content_html = array("content");
   break;
  default:
   $this->page_html = array("header", "menu","article", "footer");
   $this->content_html = array("content");
   break;     
 }
 foreach($this->page_html as $part) {
  if($part == "article") {
   if($this->parameters[0]!="" && !isset($_GET["search"])) {
    $this->assemblePage($part,$this->content_html,"single");   
   } else if (isset($_GET["search"])) {
    $this->assemblePage($part,$this->content_html,"search");  
   } else {
    $this->assemblePage($part,$this->content_html,"list");  
   }   
  } else {
    $this->registry->set('LayoutTemplate', 
     new LayoutTemplate($this->controller, 
     $this->action, $this->parameters, $this->pdo ));  
    $layouttemplate = $this->registry->get('LayoutTemplate');
    $layouttemplate->getPart($part);
  }
 }
}

public function assemblePage($part, $content, $contenttype) {
 $this->registry->set('LayoutTemplate',
  new LayoutTemplate($this->controller, $this->action, $this->parameters, $this->pdo ));  
 $lt = $this->registry->get('LayoutTemplate');
 $dbh = $this->registry->get('DbHandler');
 $article_ids = array();
 $count=0;
 switch($contenttype) {
  case "list":
  $result = $dbh->getArticleList($this->pdo);    
   while ($row=$result->fetch()) {
    $article_ids[$count]=$row["article.article_id"];
    $count++;
   }
   break;
  case "search":
  $result = $dbh->getSearchResults($this->pdo);    
   while ($row=$result->fetch()) {
    $article_ids[$count]=$row["article.article_id"];
    $count++;
   }
   break;
  default:
  $article_ids[0]=$this->parameters[0];
   break;
 }
  for($i=0;$i<sizeof($article_ids);$i++) {
 foreach ($content as $content_part) {
  if ($content_part == "content") {
   $lt->getContent($article_ids[$i]);
   } else {
   if ($this->parameters[0]==""||is_numeric($this->parameters[0])||isset($_GET["search"])) {
    $lt->getPart($content_part, $article_ids[$i]);
    } else {  
    $result2 = $dbh->getArticleByName($this->pdo,$this->parameters); 
     while ($row=$result2->fetch()) {
     $article_ids[0]=$row["article.article_id"];
     }           
     $lt->getPart($content_part, $article_ids[0]);
    }
   }
  }
 }
}

} ?>