<?php
class Comment {
  public $id=0;			// int
  public $userId;		// String
  public $author; 		// String
  public $articleId;	// Array holding array of article summaries
  public $replyToId;
  public $posted;
  public $validated = false; 	// Is category validated
  public $database;
  public $indent;
  public $connection;
  
  function __construct ($id=0, $articleid, $userid, $author, $comment, $date, $replyid=0, $indent=0) {
    $this->registry    = Registry::instance();
    $this->database    = $this->registry->get('database');  
    $this->connection  = $this->database->connection;
    $this->id          = $id;
    $this->articleId   = $articleid;
    $this->author      = $author;
    $this->userId      = $userid;
    $this->comment     = $comment;
    $this->replyToId   = $replyid;
    $this->posted      = $date;
    $this->indent = $indent;
  }

  public function create() {
    $query = "INSERT INTO comments (comment, article_id, user_id, posted, replyto_id) 
              VALUES  (:comment,:articleid, :userid, :date, :replyid)";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':comment',$this->comment);
    $statement->bindParam(':articleid',$this->articleId);
    $statement->bindParam(':userid',$this->userId);
    $date = date("Y-m-d H:i:s");
    $statement->bindParam(':date',$date);
    $statement->bindParam(':replyid',$this->replyToId);
    if ($statement->execute()) {
     return true;    
    } else {
     return '<div>Error '. $statement->errorCode() .':' . $statement->errorInfo() .'</div>';  
    }
  } 

  function update() {}

  function delete(){}

  function validate() {}
  }
?>