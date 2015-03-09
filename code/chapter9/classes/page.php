<?php
require_once('../classes/menu.php');
require_once('../classes/widgets.php');
require_once('../classes/content.php');

class Page {
    
    private $page;
    private $parameters;
    private $pdo;
    
    public function __construct($p1,$p2,$p3, $p4){
        $this->controller = $p1;
        $this->page = $p2;
        $this->parameters = $p3;
        $this->pdo = $p4;
    }
    
    public function getHeader($page) {  
        require_once ("templates/".$this->controller."_header.php");
    }
    public function getFooter($page) {
        require_once ("templates/".$this->controller."_footer.php");
    }
    public function getMenu() {
        return new Menu;
    }
    public function getWidgets() {
        return new Widgets;
    } 
    public function getContent() {
        return new Content($this->page,$this->parameters,$this->pdo);
    }
}
?>