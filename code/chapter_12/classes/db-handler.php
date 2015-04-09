<?php
 class DbHandler{   
     
    public function getArticleById($pdo, $id ) {
        $select_singlearticle_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=".$id;
        $select_singlearticle_result = $pdo->prepare($select_singlearticle_sql);
        $select_singlearticle_result->execute();
        $select_singlearticle_result->setFetchMode(PDO::FETCH_ASSOC);
        return $select_singlearticle_result;
    }
    
    public function getArticleByName($pdo, $title) {
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
        //Needs to return TotalComments amount
        $select_comments_sql = "select count(*) as TotalComments From comments WHERE article_id = ".$articleid;
        $select_comments_result = $pdo->prepare($select_comments_sql);
        $select_comments_result->execute();
        $select_comments_result->setFetchMode(PDO::FETCH_ASSOC);
        $total=0;
        while ($row = $select_comments_result->fetch()) {
            $total=$row[".TotalComments"];      
        }
        if ($total!=0) {
            $select_comments_sql = "select (select count(*) as TotalComments  From comments where article_id=".$articleid.") as TotalComments, comments_id, comment_repliedto_id, comment, full_name, comment_date, article_id FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$articleid." Order by Comments_id desc";
        }  else{
        $select_comments_sql = "select count(*) as TotalComments, comments_id, comment_repliedto_id, comment, full_name, comment_date, article_id FROM comments JOIN user ON comments.user_id = user.user_id WHERE article_id = ".$articleid." Order by Comments_id desc";
        }  
        //echo $select_comments_sql;
        $select_comments_result = $pdo->prepare($select_comments_sql);
        $select_comments_result->execute();
        $select_comments_result->setFetchMode(PDO::FETCH_ASSOC);
        return $select_comments_result;
    }
    
    public function getAuthorName($pdo, $article_id ) {    
        $select_singlearticle_sql = "select full_name FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id='".$article_id."'";
        $select_singlearticle_result = $pdo->prepare($select_singlearticle_sql);
        $select_singlearticle_result->execute();
        $select_singlearticle_result->setFetchMode(PDO::FETCH_ASSOC);
        return $select_singlearticle_result;
    }
    
    public function getAllLikes($pdo, $user_id,$article_id) {
        $select_singlearticle_sql = "select coalesce(a.article_id,".$article_id.") as articleid, coalesce(".$user_id.",0) as userid,  Count(*) as likes_count, (select count(like_id) as likes FROM article_like where article_id='".$article_id."') as likes_total FROM article_like as a  join (select user_id FROM article_like as b where article_id='".$article_id."' and user_id='".$user_id."' ) as c ON (c.user_id = a.user_id) where article_id='".$article_id."'" ;
        $select_singlearticle_result = $pdo->prepare($select_singlearticle_sql);
        $select_singlearticle_result->execute();
        $select_singlearticle_result->setFetchMode(PDO::FETCH_ASSOC);
        return $select_singlearticle_result;
    }
}


?>