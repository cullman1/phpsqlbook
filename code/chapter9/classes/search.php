<?php
class Search {
    private $store = array();
    
    public function getSearchStyle() 
    {
        require_once ("templates/menustyle.php");
    }
    public function getSearchTemplate() 
    {
        require_once ("templates/menutemplate.php");
    }
}
?>