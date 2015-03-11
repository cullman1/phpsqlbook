<?php
 class DbHandler{   
     
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
}


?>