<?php 
class Like {
  public $total;
  public $likedByUser;
  public $articleId;
  public $userId;
  public $connection;

  function __construct ($articleid, $userid) {
    $this->registry   = Registry::instance();
    $this->database   = $this->registry->get('database');
    $this->connection =  $this->database->connection;
    $this->articleId  = $articleid;
    $this->userId     = $userid;
  }

  function getCount() {
    $query = "SELECT count(*) as likes_count FROM like 
              WHERE article_id=:id and user_id=:userid"; 
    $statement = $connection->prepare($query);
    $statement->bindParam(':id', $this->$article_id);
    $statement->bindParam(':userid', $this->user_id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);  
    return $statement->fetchAll()->{".likes_count"};  
  }

  function getTotal() {
    $query = "SELECT count(article_id) as likes_total 
              FROM like WHERE article_id=:id"; 
    $statement = $connection->prepare($query);
    $statement->bindParam(':id', $this->$article_id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);  
    return $statement->fetchAll()->{".likes_total"};  
  }
} 
?>