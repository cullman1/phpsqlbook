<?php
class Article{
  public  $id;
  public  $title;
  public  $summary;
  public  $content;
  public  $created;
  public  $category_id;
  public  $category;
  public  $user_id;
  public  $author;
  public  $author_image;
  public  $published;
  public  $seo_title;
  public  $seo_user;
  public  $like_count;
  public  $comment_count;
  public  $liked;

  public function __construct($id = NULL, $title = NULL, $summary = NULL, $content = NULL, $category_id = NULL, $user_id = NULL, $published = NULL) {
    $this->id           = $id;
    $this->title        = $title;
    $this->summary      = $summary;
    $this->content      = $content;
    $this->category_id  = $category_id;
    $this->user_id      = $user_id;
    $this->published    = $published;
  }

}