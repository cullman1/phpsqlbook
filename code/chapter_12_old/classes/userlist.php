<?php
class UserList {
  public $users = array();			// Array holding child objects
  public $database;

  function __construct($database, $user_list) {
    $this->database = $database;
    $count = 0;
    foreach($user_list as $row) {
      $user = new User($database, $row->{"category.name"});
      $this->users[$count] = $user;
      $count++;
    }
  }
}
?>
