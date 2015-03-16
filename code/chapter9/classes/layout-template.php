<?php
require_once('../classes/registry.php');

class LayoutTemplate {
    private $registry;
    public function parseTemplate($recordset, $category_modifier, $controller, $pdo) {
        //Removes modifier for time being
        if(isset($category_modifier)) {
            $category_modifier = "";
        } 
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter9/classes/templates/".$category_modifier.$controller."_content.php");
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
            //$this->registry = Registry::instance();
            //$dbhandler = $this->registry->get('DbHandler');
            //$recordset2 = $dbhandler->getArticleComments($pdo, $row["article.article_id"]);
            //$this->writeComments($recordset2, "total_");
            //$this->writeComments($recordset2,"");
            //echo "</div></div>";
        }
    }
    
    public function writeComments($recordset, $total)
    {   
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter9/classes/templates/".$total."comments_content.php");
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