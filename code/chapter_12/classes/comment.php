<?php
class Comment {
  public $id=0;			// int
  public $comment;		// String
  public $author; 		// String
  public $articleId;	// Array holding array of article summaries
  public $repliedToId;
  public $posted;
  public $validated = false; 	// Is category validated
  public $database;
  public $articleCount;
  

  function __construct ($id, $articleid, $userid=0, $comment=0, $commentid=0) {
    $this->database =Registry::instance()->get('database');  
    $this->connection =  $this->database->connection;
     $this->id       = $id;
      $this->articleId       = $articleid;
      $this->author        = $userid;
      $this->comment      = $comment;
            $this->repliedToId      = $commentid;
       $date = date("Y-m-d H:i:s");
          $this->posted =$date;
  }


  public function create($articleid, $userid, $date, $comment, $commentid=0) {
 $query = "INSERT INTO comments (comment, article_id, user_id, posted, repliedto_id) 
           VALUES  (:comment,:articleid, :userid, :date, :commentid)";
 $statement = $this->connection->prepare($query);
  $statement->bindParam(':comment',$comment);
 $statement->bindParam(':articleid',$articleid);
  $statement->bindParam(':userid',$userid);
 $statement->bindParam(':date',$date);
  $statement->bindParam(':commentid',$commentid);
 if ($statement->execute()) {
    return true;    
  } else {
    return '<div>Error '. $statement->errorCode() .':' . $statement->errorInfo() .'</div>';  
  }
} 

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
    $result = hyphenate_url($article_list);
    if (isset($result)) {
      $this->id 		= $result->id;
      $this->name 	= $result->name;
      $this->template = $result->template;
    }
    return $article_list; 
}




  function validate() {}
  }
?>