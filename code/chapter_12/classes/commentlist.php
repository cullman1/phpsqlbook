<?php
class CommentList {
  public $comments = array();// Array holding child objects
  public $commentCount;

  function __construct($comment_list) {   
    $count = 0;
    $indent=0;
    $this->recursiveAddComment($comment_list, $count, $indent);
  }

  public function add($id, $articleid, $userid, $author, $comment, $posted, $repliedtoid='0') {
    $count = sizeof( $this->comments);
    $this->comments[$count] = new Comment($id,$articleid,$userid, $author, $comment, $posted , $repliedtoid ,'','' );
    return $this;
  }

  public function recursiveAddComment($comment_list, $count, $indent) {
      foreach($comment_list as $row) {
         // 
 
          if (isset($row->{"children"})) {   
              $indent = $indent+20;
              $this->recursiveAddComment(($row->{"children"}), $count,$indent);
          } else { 
              $comment = new Comment($row->{"comments.id"},$row->{"comments.article_id"}, $row->{"comments.user_id"},$row->{"user.forename"} . " ". $row->{"user.surname"},$row->{"comments.comment"} , $row->{"comments.posted"} , $row->{"comments.repliedto_id"}, '',$indent );
              $this->comments[$count] = $comment;
              $count++;
          }

      }
  }
}
?>
