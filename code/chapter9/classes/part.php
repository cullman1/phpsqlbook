<?php
class Part {
    private $part;
    
    public function __construct($part) {   
        $this->part = $part;
        
    }
    
    public function getTemplate()
    {
        require_once ("templates/".$this->controller."_".$this->part.".php");
    }
    
    public function getSearchResults($dbHost) {
        $trimmed_search = trim($_GET["search"]);
        $searchterm =  "AND ((title like '%" . $trimmed_search . "%') ";
        $searchterm .= "OR (content like '%" . $trimmed_search . "%'))";
        $search_sql =  "select article_id, title, content, date_posted FROM article ";
        $search_sql .= "where date_published <= now() " . $searchterm . " order by article_id DESC";

        $select_articles_result = $dbHost->prepare($search_sql);
        $select_articles_result->execute();
        $select_articles_result->setFetchMode(PDO::FETCH_BOTH); 

        return $select_articles_result;
    }
}
?>