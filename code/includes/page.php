<?php
require_once('../includes/headerclass.php');
require_once('../includes/footerclass.php');
require_once('../includes/menuclass.php');
require_once('../includes/widgetsclass.php');
require_once('../includes/contentclass.php');

abstract class Page {
    public function getHeader() {  
        return new Header;
    }
    public function getFooter() {
        return new Footer;
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