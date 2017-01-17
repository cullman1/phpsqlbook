<?php
class Comment {
    public $id=0;              // Identifier of the comment    
    public $articleId;         // Identifier of the article
    public $userId;            // Identitier of the author
    public $author;            // Name of the author
    public $comment;           // Comment text
    public $posted;            // Date comment was posted
    public $replyToId;       // Id of comment replied to
    public $validated = false; // Is comment validated?
    private $registry;
    private $database;
    public $connection;
    public $indent;
    
    function __construct ($id=0, $articleid, $userid, 
                 $author, $comment, $date, $replyid=0, $indent='') {
        $this->registry   = Registry::instance();
        $this->database   = $this->registry->get('database');
        $this->connection = $this->database->connection;
        $this->id         = $id;
        $this->articleId  = $articleid;
        $this->author     = $author;
        $this->userId     = $userid;
        $this->comment    = $comment;
        $this->replyToId= $replyid;
        $this->posted     = $date;
        $this->indent = $indent;
    }

    public function create() {
        $query = "INSERT INTO comments (comment, article_id, 
    user_id, posted, repliedto_id) VALUES (:comment,
    :articleid, :userid, :date, :replyid)";
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
            return '<div>Error '. $statement->errorCode() . 
                   $statement->errorInfo() .'</div>';  
        }
    } 
} 
?>