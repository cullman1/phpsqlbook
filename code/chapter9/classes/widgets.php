<?php
require_once('../classes/menu.php');
require_once('../classes/search.php');

class Widgets {
    private $store = array();
    
    public function getMenu() 
    {
        return new Menu;
    }
    public function getSearch() 
    {
        return new Search;
    }
}
?>
?>