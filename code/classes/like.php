<?php 
class Like {
  public $total;
  public $liked;
  public $articleId;
  public $userId;
  public $connection;

  function __construct ($article_id, $user_id) {
    $this->registry   = Registry::instance();
    $this->database   = $this->registry->get('database');
    $this->connection = $this->database->connection;
    $this->articleId  = $article_id;
    $this->userId     = $user_id;
  }

  function setLiked() {
    $query = "SELECT count(*) as liked FROM liked WHERE article_id=:articleid and user_id=:userid"; 
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':articleid', $this->articleId);
    $statement->bindParam(':userid', $this->userId);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);  
    $liked = $statement->fetch();
    $this->liked = $liked->{'.liked'};
  }

  function setTotal() {
      $query = "SELECT count(*) as total FROM liked WHERE article_id= :articleid"; 
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':articleid', $this->articleId);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);  
     $liked = $statement->fetch();  
     $this->total = $liked->{".total"};
  }

  function add() { 
      $sql = "INSERT INTO liked (user_id, article_id) VALUES (:userid, :articleid)";
      $statement = $this->connection->prepare($sql);
      $statement->bindParam(":userid", $this->userId);
      $statement->bindParam(":articleid", $this->articleId);
      $statement->execute();
  }

  function delete() {
      $sql = "DELETE FROM liked WHERE user_id= :userid AND article_id= :articleid";
      $statement = $this->connection->prepare($sql);
      $statement->bindParam(":userid", $this->userId);
      $statement->bindParam(":articleid", $this->articleId);
      $statement->execute();
  }
} 
?>