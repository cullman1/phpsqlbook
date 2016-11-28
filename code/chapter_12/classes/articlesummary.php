<?php

class ArticleSummary {
  public  $id;
  public  $title;
  public  $content;
  public  $intro;
  public $published;
  public $categorytemplate;
  public $categoryname; 
  public $articleurl;
  private $category_id;
  private $user_id;
  private $media_id;
  public $comments_count;
  public $comments = array();
  private $validated = FALSE;
  private $connection;

  
  function __construct($database, $id, $title, $intro, $published, $user_id, $categorytemplate, $categoryname) {
     $this->id 		= $id;
     $this->title 	= $this->hyphenate_url($title);
      $this->articleurl 	= $this->hyphenate_url($title);
      $this->content = $intro;
      $this->published = $published;
      $this->categorytemplate = $categorytemplate;
       $this->categoryname = $categoryname;
      $this->user_id = $user_id;
        $this->database = $database;
  }

  function hyphenate_url($title) {

        $title = str_replace(' ','-', $title);
   
    return $title;
}
   
  function validate($new = FALSE) {}

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

    if (isset($article_list)) {
      $this->id 		= $result->id;
      $this->name 	= $result->name;
      $this->template = $result->template;
      $this->articleurl = $this->hyphenate_url($result->title);
    }
    return $article_list; 
}

public function getComments() {
    $query="select comments.*, user.* FROM comments JOIN user ON comments.user_id = user.id  WHERE article_id = :articleid Order by comments.id desc";  
    $statement = $this->database->connection->prepare($query);
    $statement->bindParam(':articleid',$this->id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $this->comments = $statement->fetchAll();
    return $this->comments;
  }

  public function getCommentHeader() {
  $query= "select uuid() As new_id From article WHERE id = :articleid";
  $statement = $this->database->connection->prepare($query);
  $statement->bindParam(':articleid',$this->id);
  $statement->execute();
      $statement->setFetchMode(PDO::FETCH_OBJ);
      $header = $statement->fetchAll();  
      return $header;
  }




  function create() {}

  function update() {}

  function delete() {}
}


?>