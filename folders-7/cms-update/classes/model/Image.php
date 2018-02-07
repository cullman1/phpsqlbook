<?php
class Image {
  public $image_id;
  public $alt;
  public $file;

  function __construct($image_id = NULL, $alt = NULL, $file = NULL) {
    $this->image_id        = $image_id;
    $this->alt       = $alt;
    $this->file  = $file;
  }
}