<?php
class CategoryList {
  public $categories = array();			// Array holding child objects

  function __construct($category_list) {
    $count = 0;
    foreach($category_list as $row) {
      $category = new Category($row->{"category.name"});
      $this->categories[$count] = $category;
      $count++;
    }
  }
}
?>
