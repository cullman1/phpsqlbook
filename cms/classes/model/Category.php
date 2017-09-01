<?php

class Category{
  public  $id;
  public  $name;
  public  $description;
  public  $navigation;

    public function __construct( ) {
       $this->description = $this->remove_letter($this->description) ;
   }

   private function remove_letter($word) { 
     $word = str_replace("e", "", $word);
     return $word;
}

}