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
  public $user_id;
  private $media_id;
  public $comments_count;
  public $comments = array();
  private $validated = FALSE;
  private $connection;

  
  function __construct($id, $title, $intro, $published, $user_id, $categorytemplate, $categoryname) {

    $this->database = Registry::instance()->get('database');   
    $this->connection =  $this->database->connection;    
 $this->id 		= $id;
     $this->title 	= $this->hyphenate_url($title);
      $this->articleurl 	= $this->hyphenate_url($title);
      $this->content = $intro;
      $this->published = $published;
      $this->categorytemplate = $categorytemplate;
       $this->categoryname = $categoryname;
      $this->user_id = $user_id;
  }

  function hyphenate_url($title) {

        $title = str_replace(' ','-', $title);
   
    return $title;
}
   
  function validate($new = FALSE) {}


public function getComments() {
    $query="select comments.*, user.* FROM comments JOIN user ON comments.user_id = user.id  WHERE article_id = :articleid Order by comments.id desc";  
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':articleid',$this->id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $this->comments = $statement->fetchAll();
    return $this->comments;
  }

  public function getCommentHeader() {
  $query= "select uuid() As new_id From article WHERE id = :articleid";
  $statement = $this->connection->prepare($query);
  $statement->bindParam(':articleid',$this->id);
  $statement->execute();
      $statement->setFetchMode(PDO::FETCH_OBJ);
      $header = $statement->fetch();  
      return $header;
  }

  function create() {}

  function update() {}

  function delete() {}
}


?>