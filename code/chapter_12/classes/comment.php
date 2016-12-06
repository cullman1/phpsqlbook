<?php
class Comment {
  public $id=0;			// int
  public $userId;		// String
  public $author; 		// String
  public $articleId;	// Array holding array of article summaries
  public $repliedToId;
  public $posted;
  public $validated = false; 	// Is category validated
  public $database;

  
  function __construct ($id=0, $articleid, $userid, $author, $comment, $date, $commentid=0) {
    $this->registry    = Registry::instance();
    $this->database    = $this->registry->get('database');  
    $this->connection  = $this->database->connection;
    $this->id          = $id;
    $this->articleId   = $articleid;
    $this->author   =    $author;
    $this->userId      = $userid;
    $this->comment     = $comment;
    $this->repliedToId = $commentid;
    $this->posted      = $date;
  }

  public function create() {
    $query = "INSERT INTO comments (comment, article_id, user_id, posted, repliedto_id) 
              VALUES  (:comment,:articleid, :userid, :date, :commentid)";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':comment',$this->comment);
    $statement->bindParam(':articleid',$this->articleId);
    $statement->bindParam(':userid',$this->userId);
    $date = date("Y-m-d H:i:s");
    $statement->bindParam(':date',$date);
    $statement->bindParam(':commentid',$this->repliedToId);
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