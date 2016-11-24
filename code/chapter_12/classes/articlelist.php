<?php
class ArticleList {
  private $validated = FALSE;
  private $database;

  function __construct($database, $category = 0, $show, $from, $sort='', $dir='ASC', $search = '', $author_id='0', $name='') {
    $this->database = $database;

    $query= "select article.*, category.* FROM article JOIN user ON user.id = article.user_id JOIN category ON category.id= article.category_id where published <= now()";
    
    if (!empty($search)) {  //search results
      $search = trim($search);
      $searchsql = " AND ((title like '%" .$search. "%')";
      $searchsql .= " OR (content like '%".$search. "%'))";
      $query .= $searchsql;   
    }
  
    //category list
    if (($category > 0) && (!empty($name))) {
       $query .= ' AND  title=:name AND article.category_id = :id';
    } else if ($category > 0) {
      $query .= ' AND article.category_id = :id';
    }
    
    //author list
    if ($author_id > 0) {
      $query .= ' AND user.id = :id';
    }

    //Sort
    if (!empty($sort)) {
      $query .= " Order By " . $show . " " . $dir;
    }

    //Get total number of articles for count
    $articles_for_count = $this->bind_parameters( $query, $category, $name, $author_id);          
    $num_rows = count($articles_for_count);
    //Get actual limited page of articles
    $query .= " limit " . $show . " offset " . $from;
    $article_list = $this->bind_parameters( $query, $category, $name, $author_id);
    $article_list = $this->hyphenate_url($article_list);
    return $this->append_row_count($article_list,$num_rows);
}

 public function bind_parameters( $query, $category, $name, $author_id) {
     $statement =$this->database->connection->prepare($query);
    if (($category > 0) && (!empty($name))) {
       $statement->bindParam(":name", $name); 
       $statement->bindParam(":id", $category); 
    }  else if ($category > 0) {
     $statement->bindParam(":id", $category);    
    }
    if ($author_id > 0) {
        $statement->bindParam(":id", $author_id);    
    }
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article_list = $statement->fetchAll();  
    return $article_list;
}

  public function hyphenate_url($article_list) {
    foreach ($article_list as $article) {
        $article->{"article.title_url"} = str_replace(' ','-', $article->{"article.title"});
    }
    return $article_list;
}

public function append_row_count($article_list, $num_rows) {
    foreach ($article_list as $article) {
     $article->{"article.row_count"} = $num_rows;
     }
    return $article_list;
}
}
?>