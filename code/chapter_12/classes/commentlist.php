<?php

class CommentList {
  public $comments = array();// Array holding child objects
  public $commentCount;

  function __construct($comment_list) {   
    $this->commentCount = 0;
     $new = array();  
     $nestedcomments_row = array();
     foreach ($comment_list as $row) {
        $nestedcomments_row[] = $row;
     }
     foreach ($nestedcomments_row as $branch) {
        $new[$branch->{'comments.repliedto_id'}][]=$branch;             
     }
     if (isset($new[0])) { 
        $comment_list = $this->create_tree($new, $new[0],0);
     }
  }

  function create_tree(&$list, $parent,$indent){
    $tree = array();
    foreach ((array) $parent as $key=>$reply) {
      if ($this->commentCount>0) {
       $indent= 0;
       foreach ($this->comments as $comment) {
          //Search the array for indentation of previous array
          if ($comment->id == $reply->{"comments.repliedto_id"}) {
             $indent = $comment->indent + 20; //Add an indent
          } 
       }
      }
      $comment =  new Comment($reply->{"comments.id"},$reply->{"comments.article_id"}, $reply->{"comments.user_id"},$reply->{"user.forename"} . " ". $reply->{"user.surname"},$reply->{"comments.comment"} , $reply->{"comments.posted"} , $reply->{"comments.repliedto_id"}, $indent );
      $this->comments[$this->commentCount] = $comment;
      $this->commentCount++;
      if (isset($list[$reply->{'comments.id'}])) {
        $indent=$indent+20;
        $reply->{'children'} = $this->create_tree($list, $list[$reply->{'comments.id'}],$indent);
      } 
      $tree[] = $reply;
    } 
    return $tree;
  }

  public function add($id, $articleid, $userid, $author, $comment, $posted, $repliedtoid='0') {
    $count = sizeof( $this->comments);
    $this->comments[$count] = new Comment($id,$articleid,$userid, $author, $comment, $posted , $repliedtoid ,'');
    return $this;
  }
}
?>
