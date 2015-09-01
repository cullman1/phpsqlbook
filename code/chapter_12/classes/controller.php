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
    
    public function createPageStructure() {     
        switch( $this->controller) {
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
                if ($this->parameters[0]!="" && !isset($_GET["search"])) {
                    $this->assemblePage($part, $this->content_structure, "single" );   
                } else if (isset($_GET["search"])) {
                    $this->assemblePage($part, $this->content_structure, "search" );  
                } else {
                    $this->assemblePage($part, $this->content_structure, "multiple" );  
                }
            }
            else {
                $this->registry->set('LayoutTemplate', new LayoutTemplate($this->controller, $this->action, $this->parameters, $this->pdo ));  
                $layouttemplate = $this->registry->get('LayoutTemplate');
                $layouttemplate->getPart($part);     
            }
        }
    }

    public function testParameters() {

    }
    
    public function assemblePage($part, $content, $contenttype) {
        $this->registry->set('LayoutTemplate', new LayoutTemplate($this->controller, $this->action, $this->parameters, $this->pdo ));  
        $layouttemplate = $this->registry->get('LayoutTemplate');
        $dbhandler = $this->registry->get('DbHandler');
        $article_ids = array();
        $count=0;
        switch($contentype) {
        case "multiple":
          $recordset = $dbhandler->getArticleList($this->pdo);    
          while ($row=$recordset->fetch()) {
            $article_ids[$count]=$row["article.article_id"];
            $count++;
          }
          break;
        case "search":
          $recordset = $dbhandler->getSearchResults($this->pdo);    
          while ($row=$recordset->fetch()) {
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
           $layouttemplate->getContent($article_ids[$i]);
          } else {
            if ($this->parameters[0]=="" ||is_numeric($this->parameters[0]) || isset($_REQUEST["search"])) {
              $layouttemplate->getPart($content_part, $article_ids[$i]);
            } else {  
              $recordset2 = $dbhandler->getArticleByName($this->pdo,$this->parameters); 
              while ($row=$recordset2->fetch()) {
                $article_ids[0]=$row["article.article_id"];
              }           
              $layouttemplate->getPart($content_part, $article_ids[0]);
            }
          }
        }
      }  
   }
}
?>
