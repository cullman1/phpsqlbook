<?php
class Category {
  public $id=0;			// int
  public $name;		// String
  public $template; 		// String
  public $articleSummaryList;	// Array holding array of article summaries
  public $articlesList;		// Array holding array of entire articles
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
    $result = $this->hyphenate_url($article_list);
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

  function getArticles($database, $category = 0, $show, $from, $sort='', $dir='ASC', $search = '', $author_id='0', $name='') {
  $this->database = $database;
    //search list
    if ((!empty($search)) || ($author_id > 0)) {  //search results
     $this->articleCount = count($this->getArticlesBySearch('', '', $sort='', $dir='ASC', $search, $author_id));
     $this->articlesList = $this->getArticlesBySearch($show, $from, $sort='', $dir='ASC', $search, $author_id);
    } else {
      $this->articleCount = count($this->getArticlesByCategory('', '', $sort='', $dir='ASC', $category, $name));
      $this->articlesList =  $this->getArticlesByCategory($show, $from, $sort='', $dir='ASC', $category, $name);
    }
    return $this->articlesList;
}

function getArticlesByCategory( $show, $from, $sort='', $dir='ASC', $category = 0, $name='') {
    $query= "select article.*, category.* FROM article JOIN user ON user.id = article.user_id JOIN category ON category.id= article.category_id where published <= now()";
    //category list
    if (($category > 0) && (!empty($name))) {
       $query .= ' AND  title=:name AND article.category_id = :id';
    } else if ($category > 0) {
      $query .= ' AND article.category_id = :id';
    }
    //Sort
    if (!empty($sort)) {
      $query .= " Order By " . $show . " " . $dir;
    }
    //Get actual limited page of articles
      if (!empty($show)) {
      $query .= " limit " . $show . " offset " . $from;
    }
     $statement =$this->database->connection->prepare($query);
    if (($category > 0) && (!empty($name))) {
       $statement->bindParam(":name", $name); 
       $statement->bindParam(":id", $category); 
    }  else if ($category > 0) {
     $statement->bindParam(":id", $category);    
    }
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article_list = $statement->fetchAll();  
    $article_list = $this->hyphenate_url($article_list);
    return $article_list;
}

function getArticlesBySearch($show='', $from='', $sort='', $dir='ASC', $search = '', $author_id='0') {
    $query= "select article.*, category.* FROM article JOIN user ON user.id = article.user_id JOIN category ON category.id= article.category_id where published <= now()";
    //search results
    if (!empty($search)) {  
      $search2 = "%". trim($search) . "%";
      $searchsql = " AND ((title like :search)";
      $searchsql .= " OR (content like :search))";
      $query .= $searchsql;   
    }
    //author list
    if ($author_id > 0) {
      $query .= ' AND user.id = :id';
    }
    //Sort
    if (!empty($sort)) {
      $query .= " Order By " . $show . " " . $dir;
    }
    //Get actual limited page of articles
    if (!empty($show)) {
      $query .= " limit " . $show . " offset " . $from;
    }
    $statement =$this->database->connection->prepare($query);
    if ($author_id > 0) {
        $statement->bindParam(":id", $author_id);    
    }
     if (!empty($search)) {  
         $statement->bindParam(":search", $search2);    
     }
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article_list = $statement->fetchAll();  
    $article_list = $this->hyphenate_url($article_list);
      if (!empty($search) && !empty($show)) {
      foreach($article_list as $article) {
        $article->{'article.content'} = str_ireplace($search, "<b style='background-color:yellow'>".$search."</b>", $article->{'article.content'}); 
      }
    }
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