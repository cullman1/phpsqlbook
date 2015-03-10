<?php
 class Content{   
     
    public function __construct($controller, $page,$parameters,$pdo){
        switch ($controller) {
        case "public": 
            if(empty($parameters)) {
            $this->parseTemplate($this->getArticleList($pdo));
            }
            else {
                $this->parseTemplate($this->getArticleById($parameters, $pdo));
            }
            break;
        }
     }
    
    public function getArticleById($id, $pdo) {
        $select_singlearticle_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=".$id[0];
        $select_singlearticle_result = $pdo->prepare($select_singlearticle_sql);
        $select_singlearticle_result->execute();
        $select_singlearticle_result->setFetchMode(PDO::FETCH_ASSOC);
        return $select_singlearticle_result;
    }
    public function getArticleList($pdo) {
        $select_articles_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, role_id, parent_name, article.parent_id, template FROM article JOIN user ON article.user_id = user.user_id  JOIN parent ON article.parent_id = parent.parent_id JOIN category ON article.category_id = category.category_id where date_published <= now() order by article_id DESC";
        $select_articles_result = $pdo->prepare($select_articles_sql);
        $select_articles_result->execute();
        $select_articles_result->setFetchMode(PDO::FETCH_ASSOC);
        return $select_articles_result;
    }
    
    public function parseTemplate($recordset) {
        $string = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/code/chapter9/classes/templates/article-content.php");
        $regex = '#{(.*?)}#';
        preg_match_all($regex, $string, $matches);
       
        while($row = $recordset->fetch())
        {
            $template=$string;
            //Get out content of string, replace with $row
           foreach($matches[0] as $value)
           {           
               $replace= str_replace("{","", $value);
               $replace= str_replace("}","", $replace);
               $template = str_replace($value, $row[$replace], $template);  
           }
           echo $template;
        }

    }
}


?>