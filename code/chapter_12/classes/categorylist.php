<?php
class CategoryList {
  public $categories = array();			// Array holding child objects
  public $database;

  function __construct($database, $category_list) {
    $this->database = $database;
    $count = 0;
    foreach($category_list as $row) {
      $category = new Category($database, $row->{"category.name"});
      $this->categories[$count] = $category;
      $count++;
    }
  }
}
?>
