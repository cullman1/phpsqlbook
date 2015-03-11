<?php
require_once('../classes/search.php');
require_once('../classes/registry.php');

class Layout {
    private $registry;
    private $controller;
    
    public function __construct(array $widgets, $controller, $page, $parameters, $pdo) {
        $this->pdo = $pdo;
        $this->registry = Registry::instance();
        $this->controller=$controller;
        $this->page=$page;
        $this->parameters=$parameters;
        foreach($widgets as $widget) {
            $this->registry->set($widget, new $widget($pdo));
        }
    }
    
    public function getPart($part)
    {
        require_once ("templates/".$this->controller."_".$part.".php");
    }
        
    
    public function getSearch() {
         $search = $this->registry->get("Search");
         if (isset($_GET["search"])) {
             $search->getSearchResults($this->pdo);
         }
         $search->getSearchTemplate();
    }
     
    public function getContent() {
        $this->registry->set('DbHandler', new DbHandler($this->pdo));  
        $dbhandler = $this->registry->get('DbHandler');
        switch ($this->controller) {
            case "public": 
                if(empty($this->parameters)) {
                    
                    $this->parseTemplate($dbhandler->getArticleList($this->pdo));
                }
                else {
                    
                    $this->parseTemplate($dbhandler->getArticleById($this->parameters, $this->pdo));
                }
                break;
        } 
    }
    
    public function parseTemplate($recordset) {
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter9/classes/templates/article-content.php");
        $regex = '#{{(.*?)}}#';
        preg_match_all($regex, $string, $matches);
        while($row = $recordset->fetch())
        {
            $template=$string;
            //Get out content of string, replace with $row
            foreach($matches[0] as $value) {           
                $replace= str_replace("{{","", $value);
                $replace= str_replace("}}","", $replace);
                $template = str_replace($value, $row[$replace], $template);  
            }  
            echo $template;
        }
    }
    
   
}
?>
