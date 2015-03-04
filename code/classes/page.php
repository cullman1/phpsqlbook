<?php
require_once('../classes/menuclass.php');
require_once('../classes/widgetsclass.php');
require_once('../classes/contentclass.php');

abstract class Page {
    public function getHeader() {  
        require_once ("../includes/header.php");
    }
    public function getFooter() {
        require_once ("../includes/footer.php");
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