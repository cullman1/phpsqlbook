<?php

class Header {
    public function getTemplatePath() {  
        return "../includes/style.css";
    }
    public function getHeaderContent() {  
        require_once "../includes/header.php";
    }
    
}

?>