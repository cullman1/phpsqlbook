<?php
 class DbHandler{   
     
    public function getArticleById($id, $pdo) {
        $select_singlearticle_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=".$id[0];
        $select_singlearticle_result = $pdo->prepare($select_singlearticle_sql);
        $select_singlearticle_result->execute();
        $select_singlearticle_result->setFetchMode(PDO::FETCH_ASSOC);
        return $select_singlearticle_result;
    }
    
    public function getArticleByName($title, $pdo) {
        $new_title = str_replace("-"," ", trim($title[0]));
        
        $select_singlearticle_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where title='".$new_title."'";
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
    
    public function getSearchResults($pdo) {
        $trimmed_search = trim($_GET["search"]);
        $searchterm =  "AND ((title like '%" . $trimmed_search . "%') ";
        $searchterm .= "OR (content like '%" . $trimmed_search . "%'))";
        $search_sql =  "select article_id, title, content, date_posted FROM article ";
        $search_sql .= "where date_published <= now() " . $searchterm . " order by article_id DESC";

        $select_articles_result = $pdo->prepare($search_sql);
        $select_articles_result->execute();
        $select_articles_result->setFetchMode(PDO::FETCH_BOTH); 

        return $select_articles_result;
    }
    
    public function getPaginationResults($pdo, $count, $page)
    {
        $searchterm="";
        if (isset($_REQUEST["search"])) {
            $trimmed_search = trim($_GET["search"]);   
            $searchterm =  "AND ((title like '%" . $trimmed_search . "%') "; // What searching for
            $searchterm .= "OR (content like '%" . $trimmed_search . "%'))"; // What searching for
        }
        $total_results =  $pdo->prepare("select COUNT(*) FROM article  where date_published <= now() " . $searchterm);
        $total_results->execute();
        $total = $total_results->fetchColumn(); 
        $total_pages = ceil($total / $count);                 // Total pages of results

        $search_sql =  "select article_id, title, content, date_posted FROM article ";
        $search_sql .= "where date_published <= now() " . $searchterm;
        $search_sql .= " order by article_id DESC";
        $search_sql .= " limit " . $count . " offset " . ($page * $count);
        $select_articles_result = $pdo->prepare($search_sql);
        $select_articles_result->execute();
        $select_articles_result->setFetchMode(PDO::FETCH_ASSOC);   
        
        return $select_articles_result;
    }
    
    public function getArticleComments($pdo, $articleid)
    {
        $select_comments_sql = "select (select count(*) as TotalComments FROM comments  WHERE article_id =".$articleid.") as TotalComments, comments_id, comment_repliedto_id, comment, full_name, comment_date, article_id FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$articleid." Order by Comments_id desc";
        $select_comments_result = $pdo->prepare($select_comments_sql);
        $select_comments_result->execute();
        $select_comments_result->setFetchMode(PDO::FETCH_ASSOC);
        return $select_comments_result;
    }
    
}


?>