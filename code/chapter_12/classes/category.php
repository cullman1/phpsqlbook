<?php
class Category {
  public $id=0;			// int
  public $name;		// String
  public $template; 		// String
  public $articleSummaries;	// Array holding array of article summaries
  public $articles;		// Array holding array of entire articles
  public $articleCount;
  public $validated = false; 	// Is category validated
  public $database;
  

  function __construct($database, $name) {
    $query = "SELECT category.id, category.name, category.template FROM category WHERE name LIKE :name";     // Query
    $statement = $database->connection->prepare($query); // Prepare
    $statement->bindParam(":name", $name);                    // Bind
    $statement->execute();                                // Execute
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $category_list = $statement->fetchAll(); 
    if (count($category_list)>0) { 
      $this->id       = $category_list[0]->{"category.id"};
      $this->name     = $category_list[0]->{"category.name"};
      $this->template = $category_list[0]->{"category.template"};
    } 
  }

  function create() {}
  function update() {}
  function delete(){}

   function getById($id,  $search='') {
    $query = "select article.*, category.* FROM article JOIN user ON article.user_id = user.id JOIN category ON article.category_id = category.id where article.id= :id";
    $statement = $this->connection->prepare($query);          // Prepare
    $statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
    $statement->execute();                              // Execute
    $statement->setFetchMode(PDO::FETCH_OBJ);           // Object
    $article_list = $statement->fetchAll(); 
    if (isset($search)) {
      foreach($article_list as $article) {
        $article->{'article.content'} = str_ireplace($search, "<b style='background-color:yellow'>".$search."</b>", $article->{'article.content'}); 
      }
    }
    $result = hyphenate_url($article_list);
    if (isset($result)) {
      $this->id 		= $result->id;
      $this->name 	= $result->name;
      $this->template = $result->template;
    }
    return $article_list; 
}



  function getCategoryByID() {}

  function getArticleSummariesByID() {
   // $this->articleSummaries = … Code to get the article summaries and assign them to the $articleSummaries property … 
  }

  function getArticlesByID($database, $category = 0, $show, $from, $sort='', $dir='ASC', $search = '', $author_id='0', $name='') {
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
    $this->articleCount = count($articles_for_count);

    //Get actual limited page of articles
    $query .= " limit " . $show . " offset " . $from;
    $article_list = $this->bind_parameters( $query, $category, $name, $author_id);
    $article_list = $this->hyphenate_url($article_list);
    return $article_list;
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

  function validate() {}
  }
?>