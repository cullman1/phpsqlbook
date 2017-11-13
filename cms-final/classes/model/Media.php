<?php
class Media {
  public $id;
  public $alt;
  public $file;

  function __construct($id = NULL, $alt = NULL, $file = NULL) {
    $this->id        = $id;
    $this->alt       = $alt;
    $this->file  = $file;
  }
}