<?php

 class Content{   
    public function addContent() {
        
    }
    public function viewContent() {
        
    }
    public function editContent() {
        
    }
    public function getArticleById($id) {
        $select_singlearticle_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=".$id;
        $select_singlearticle_result = $dbHost->prepare($select_singlearticle_sql);
        $select_singlearticle_result->execute();
        $select_singlearticle_result->setFetchMode(PDO::FETCH_ASSOC);
        
        
    }
    public function getArticleList() {
        
    }
}


?>