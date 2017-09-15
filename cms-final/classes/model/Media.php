<?php
Class Media
{
  public $id;
  public $title;
  public $alt;
  public $filename;
  public $filepath;

  function __construct($id = NULL, $title = NULL, $alt = NULL, $filename = NULL, $filepath = NULL) {
    $this->id        = $id;
    $this->title     = $title;
    $this->alt       = $alt;
    $this->filename  = $filename;
    $this->filepath  = $filepath;
  }
}