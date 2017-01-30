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
        $new[$branch->{'comments.replyto_id'}][]=$branch;             
     }
     if (isset($new[0])) { 
        $comment_list = $this->create_tree($new, $new[0]);
     }
  }

  function create_tree(&$list, $parent){
    $tree = array();
    $indent=0;
    foreach ((array) $parent as $key=>$reply) {
      if ($this->commentCount>0) {
       foreach ($this->comments as $comment) {
          //Search the array for indentation of previous array
          if ($comment->id == $reply->{"comments.replyto_id"}) {
             $indent = $comment->indent + 40; //Add an indent
          } 
       }
      }
      $comment = $this->add($reply->{"comments.id"},$reply->{"comments.article_id"}, $reply->{"comments.user_id"},$reply->{"user.forename"} . " ". $reply->{"user.surname"},$reply->{"comments.comment"} , $reply->{"comments.posted"} , $reply->{"comments.replyto_id"}, $indent);
      if (isset($list[$reply->{'comments.id'}])) {
        $reply->{'children'} = $this->create_tree($list, $list[$reply->{'comments.id'}]);
      } 
      $tree[] = $reply;
    } 
    return $tree;
  }

  public function add($id, $articleid, $userid, $author, $comment, $posted, $reply='0', $indent='0') {
    $count = sizeof($this->comments);
    $this->comments[$count] = new Comment($id,$articleid,$userid, $author, $comment, $posted , $reply ,$indent);
    if ($userid !='') { 
      $this->commentCount++; 
    }
    return $this;
  }
}
?>
