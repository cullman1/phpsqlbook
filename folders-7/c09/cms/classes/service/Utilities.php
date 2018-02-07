<?php
/**
 * Created by PhpStorm.
 * User: Jon
 * Date: 18/09/2017
 * Time: 10:56
 */

class Utilities
{
  public static function redirect($page) {
     header( "Location: http://".$_SERVER['HTTP_HOST']. ROOT. $page );
     exit();
  }
  


  public static function clean($item) {
    return htmlentities($item, ENT_QUOTES, 'UTF-8') ;
  }

  public static function cleanLink($item) {
    return htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ;
  }

  public static function punyCodeDomain($email) {
   $split_email =  explode('@', $email);
   $domain = idn_to_ascii($split_email[1]); 
   $email = $split_email[0]. '@' . $domain;
    return $email;
  }

 
}