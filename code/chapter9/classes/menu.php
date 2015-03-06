<?php
class Menu {
    private $store = array();
    
    public function getMenuStyle() 
    {
        require_once ("templates/menustyle.php");
    }
    public function getMenuTemplate() 
    {
        require_once ("templates/menutemplate.php");
    }
}
?>