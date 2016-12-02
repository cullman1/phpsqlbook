<?php
class Category {
  public $id=0;			// int
  public $name;		// String
  public $template; 		// String
  public $articleSummaryList;	// Array holding array of article summaries
  public $articlesList;		// Array holding array of entire articles
  public $articleCount;
  public $validated = false; 	// Is category validated
  public $connection;
  public $database;

  function __construct($name) { 
    $this->database =Registry::instance()->get('database');  
    $this->connection =  $this->database->connection;
    $query = "SELECT category.id, category.name, category.template FROM category WHERE name like :name";     // Query
    $statement = $this->connection->prepare($query); // Prepare
    $statement->bindParam(":name", $name);                    // Bind
    $statement->execute();                                // Execute
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $category = $statement->fetch(); 
    if($category) {
      $this->id       = $category->{"category.id"};
      $this->name     = $category->{"category.name"};
      $this->template = $category->{"category.template"};
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

  function validate() {}
  }
?>