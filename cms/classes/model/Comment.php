<?php

class Comment {
    public $id;                 // Unique number to identify comment
    public $article_id;         // id of the article the comment is made upon
    public $user_id;            // id of the user who made the comment
    public $comment;            // The text of the user's comment
    public $posted;             // When the comment was written
    public $reply_to_id;        // Only used for nested comments see pXXX
    public $parent_id;          // Only used for nested comments see pXXX
    public $author;             // Name of author
    public $image;              // Profile picture of author

    function __construct($id='', $article_id='', $user_id=NULL, $comment=NULL, $date=NULL, 
                          $reply_to_id=0, $parent_id=0, $author=NULL, $image=NULL) {
        $this->id                = $id;
        $this->article_id        = $article_id;
        $this->user_id           = $user_id;
        $this->comment           = $comment;
        $this->posted            = $date;
        $this->reply_to_id       = $reply_to_id;
        $this->parent_id         = $parent_id;
        $this->author            = $author;
        $this->image             = $image;
    }
}
