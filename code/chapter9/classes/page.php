<?php
require_once('../classes/menu.php');
require_once('../classes/widgets.php');
require_once('../classes/content.php');

class Page {
    public function getHeader() {  
        require_once ("templates/header.php");
    }
    public function getFooter() {
        require_once ("templates/footer.php");
    }
    public function getMenu() {
        return new Menu;
    }
    public function getWidgets() {
        return new Widgets;
    } 
    public function getContent() {
        return new Content;
    }
}
?>