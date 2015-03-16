<?php
class Part {
    private $part;
    
    public function __construct($part) {   
        $this->part = $part;
    }
    
    public function getTemplate()
    {
        $controller_modifier = $this->controller."_";
        if ($this->part=="menu" || $this->part=="search")
        {
            $controller_modifier = "";
        }
        
        require_once ("templates/".$controller_modifier.$this->part.".php");
    }
    
}
?>