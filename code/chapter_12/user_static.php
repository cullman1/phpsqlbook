<?php

 class Login {
 static $logins;

 public static function getCount($dbHost) {
  $select_user_result = $dbHost->prepare("select  * from Users where email_address='morton@acme.org'");
  $select_user_result->execute();
  $select_user_result->setFetchMode(PDO::FETCH_ASSOC);
    while($select_user_row = $select_user_result->fetch()) {
       $login_total = $select_user_row["total_log_ins"] ; 
    }
  return $login_total;
 }
 public static function setCount($dbHost, $value){

        $ins_user_result = $dbHost->prepare("update Users set total_log_ins = :logins where email_address='morton@acme.org'");
        $ins_user_result->bindParam(":logins",  $value);
        $ins_user_result->execute();
        $ins_user_result->setFetchMode(PDO::FETCH_ASSOC);
   
  }
} ?>