<?php
class CommentList {
  public $comments = array();// Array holding child objects
  public $database;

  function __construct($comment_list) {
    $this->database = Registry::instance()->get('database');   
    $this->connection =  $this->database->connection;    
    $count = 0;
    foreach($comment_list as $row) {
      $comment = new Comment($row->{"comments.id"},$row->{"comments.article_id"}, $row->{"comments.user_id"},$row->{"user.forename"} . " ". $row->{"user.surname"},$row->{"comments.comment"} , $row->{"comments.posted"} , $row->{"comments.repliedto_id"}  );
      $this->comments[$count] = $comment;
      $count++;
    }
  }

  public function add($id, $articleid, $userid, $author, $comment, $posted, $repliedtoid='0') {
    $count = sizeof( $this->comments);
    $this->comments[$count] = new Comment($id,$articleid,$userid, $author, $comment, $posted , $repliedtoid  );
    return $this;
  }
}
?>
