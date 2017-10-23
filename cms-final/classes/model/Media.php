<?php
Class Media
{
  public $id;
  public $alt;
  public $filename;
  public $filepath;

  function __construct($id = NULL, $alt = NULL, $filename = NULL, $filepath = NULL) {
    $this->id        = $id;
    $this->alt       = $alt;
    $this->filename  = $filename;
    $this->filepath  = $filepath;
  }
}