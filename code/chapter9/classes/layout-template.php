<?php
require_once('../classes/registry.php');

class LayoutTemplate {

    public function parseTemplate($recordset, $category_modifier) {
        if(isset($category_modifier)) {
            $category_modifier = "";
        }
            
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter9/classes/templates/".$category_modifier."article-content.php");
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