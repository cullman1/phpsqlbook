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
  public  $article_id;
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
  public  $image_id;
  public  $image_file;
  public  $image_alt;

  public function __construct($article_id = NULL, $title = NULL, $summary = NULL,   
              $content = NULL, $category_id = NULL, $user_id = NULL, $published = NULL) {
    $this->article_id   = $article_id;
    $this->title        = $title;
    $this->summary      = $summary;
    $this->content      = $content;
    $this->category_id  = $category_id;
    $this->user_id      = $user_id;
    $this->published    = $published;
  }
}