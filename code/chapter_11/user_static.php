<?php
 class Login {
 static $logins;

 function __construct($loginCt) {
       self::$logins = $loginCt;
 }

 public static function getCount() {
  return self::$logins;
 }
 public static function setCount($value){
  self::$logins = $value;
  }
} ?>