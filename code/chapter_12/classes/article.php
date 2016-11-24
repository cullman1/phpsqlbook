<?php

class Article {
  public  $id;
  public  $title;
  public  $content;
  private $published;
  private $category_id;
  private $user_id;
  private $media_id;
  private $comments_count;
  private $comments;
  private $validated = FALSE;
  private $connection;

  function __construct($id, $name, $template) {}

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
    $result = hyphenate_url($article_list);
    if (isset($result)) {
      $this->id 		= $result->id;
      $this->name 	= $result->name;
      $this->template = $result->template;
    }
    return $article_list; 
}

public function getComments($articleid) {
    $query="select comments.*, user.* FROM comments JOIN user ON comments.user_id = user.id  WHERE article_id = :articleid Order by comments.id desc";  
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':articleid',$articleid);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $this->comments = $statement->fetchAll();
  }

  
  public function getCommentsCount($articleid) {
      $query = "select comments.* From comments WHERE article_id = :articleid";
      $statement = $this->connection->prepare($query);
      $statement->bindParam(':articleid',$articleid);
      $statement->execute();
      $statement->setFetchMode(PDO::FETCH_OBJ);
      $comments_count = $statement->fetchAll();  
      $this->comments_count  = count($comments_count);
        
  }

  public function hyphenate_url($article_list) {
    foreach ($article_list as $article) {
        $article->{"article.title_url"} = str_replace(' ','-', $article->{"article.title"});
    }
    return $article_list;
}


  function create() {}

  function update() {}

  function delete() {}
}


?>