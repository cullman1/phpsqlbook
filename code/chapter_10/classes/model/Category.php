<?php
class Category{
    public  $id;
    public  $name;
    public  $description;
    public  $navigation;

      public function __construct($id = NULL, $name = NULL, $description = NULL, $navigation = NULL) {
    $this->id          = $id;
    $this->name        = $name;
    $this->description = $description;
    $this->navigation  = $navigation;
  }
}
?>