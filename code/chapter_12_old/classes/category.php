<?php
class Category {
  public $id=0;			// int
  public $name;		// String
  public $template; 		// String
  public $articleSummaryList;	// Array holding array of article summaries
  public $articlesList;		// Array holding array of entire articles
  public $validated = false; 	// Is category validated
  public $connection;
  public $database;

  function __construct($name) { 
    $this->registry =Registry::instance();
    $this->database = $this->registry->get('database');  
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

  function validate() {}
  }
?>