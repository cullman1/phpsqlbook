<?php

class Category{
  public  $category_id;
  public  $name;
  public  $description;
  public  $navigation;
  public  $seo_name;

  public function __construct($category_id = NULL, $name = NULL, $description = NULL, $navigation = NULL) {
    $this->category_id          = $category_id;
    $this->name        = $name;
    $this->description = $description;
    $this->navigation  = $navigation;
  }
}