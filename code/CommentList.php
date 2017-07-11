class CommentList {
  public $comments = array();// Array holding child objects

  function __construct($comment_list) {   
    if (!empty($comment_list)) {
      foreach($comment_list as $comment) {
        if (empty( $comment->image) ) {
          $comment->image = "blank.png";
        }    
      }
      $this->comments = $this->sort($this->comments);
    }
  }

  public function add($id, $articleid, $userid, $forename, $surname, $image, $comment, $posted, $reply='0', $toplevelparentid='0',  $nestinglevel='0') {
    $count = sizeof($this->comments);
    $this->comments[$count] = new Comment($id, $articleid, $userid, $forename, $surname,$image, $comment, $posted, $reply,  $toplevelparentid, $nestinglevel);
    return $this;
  }

  function sort($old_list) {
    $new_list = array();
    $reverse_list = array_reverse($old_list);
    foreach ($reverse_list as $comment1) {
      $comment1->nestinglevel = 0;
      if ($comment1->repliedto_id > 0) {
        $comment1->nestinglevel = 1;
      }
      if ($comment1->toplevelparent_id == 0) {
        array_push($new_list, $comment1);
      }
      foreach ($old_list as $comment2) {
        if ($comment2->toplevelparent_id == $comment1->id) {
          array_push($new_list, $comment2);
        }
      }
    }
    return $new_list;
  }

  //End of object

}