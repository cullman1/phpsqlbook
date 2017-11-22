<?php

/**
 * Article short summary.
 *
 * Article description.
 *
 * @version 1.0
 * @author ChrisU
 */

class Article{
  public  $id;
  public  $title;
  public  $summary;
  public  $content;
  public  $created;
  public  $published;
  public  $category_id;
  public  $user_id;
  public  $category;
  public  $author;
  public  $author_image;
  public  $media_id;
  public  $media_file;
  public  $media_alt;

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