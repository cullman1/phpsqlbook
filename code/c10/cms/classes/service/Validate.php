<?php
class Validate {

    private $error_title = '';

public static function isNumber($number, $min = 0, $max = 4294967295) {
  $options = array('options' => array('min_range'=>$min, 'max_range'=>$max));
  if (!filter_var($number, FILTER_VALIDATE_INT, $options)) {
      return FALSE;
  }
  return TRUE;
}

public static function isText($string, $min = 0, $max = 30000){
   
    $length = mb_strlen($string);
    if (($length <= $min) or ($length > $max)) {
      return FALSE;
    }
    return TRUE;
  }

   public static function isEmail($email) {
    if ( (! filter_var($email, FILTER_VALIDATE_EMAIL))) {
       return FALSE;
    }
    return TRUE;
  }

  public static function isName($string, $min = 0, $max = 100){
   $string        = (isset($string)   ? $string        : '');     
  $result = preg_replace('/<[^>]*>/', '',  $string); 
  $result = trim($result);
  $length = mb_strlen($string);
  if (($length <= $min) or ($length >= $max) or ($result != $string )) {
    return FALSE;
  }
  return TRUE;
}

public static function isPassword($password) {
$error = false;
  if( (strlen($password)<8) OR (strlen($password)>32) ) { $error = TRUE; } 
  if(preg_match_all('/[A-Z]/', $password)<1) { $error = TRUE; }// if no A-Z return FALSE
  if(preg_match_all('/[a-z]/', $password)<1) { $error = TRUE; }// if no a-z return FALSE  
  if(preg_match_all('/\d/', $password)<1)    { $error = TRUE; }// if no 0-9 return FALSE   
  if (!isset($error)) {
    return FALSE;
  }
  return TRUE;
}

public static function isConfirmPassword($password, $confirm) {
    return ( ($password != $confirm) ? FALSE : TRUE ); 
 }
 public static function isDateTime($month, $day, $year, $hours='00', $minutes='00') {
  $date_time = $day . '-'. $month. '-'. $year. ' '. $hours . ':'. $minutes;
  try {
    $create_date = new DateTime($date_time);
    return TRUE;
  } catch(Exception $e) {
    return FALSE;
  }
}
public static function isHTML($string, $min, $max) {
  $string = html_entity_decode($string);
  $config = HTMLPurifier_Config::createDefault();
  $purifier = new HTMLPurifier($config);
  $config->set('Core.Encoding', 'UTF-8'); 
  $config->set('HTML.Allowed', 'p,strong,em,u,strike');
  $config->set('Cache.DefinitionImpl', null); //Switch off cache for hosted environment
  $clean_html = $purifier->purify($string);
  if ( ($clean_html != $string ) || (mb_strlen($clean_html) <= $min) || (mb_strlen($clean_html)>= $max)) {
    return FALSE;
  }
  return TRUE;
}
public static function sanitizeHTML($string) {
  $config = HTMLPurifier_Config::createDefault();
  $purifier = new HTMLPurifier($config);
  $config->set('Core.Encoding', 'UTF-8');
  $config->set('HTML.Allowed', 'em,strong,u,strike,p,br');
  $config->set('Cache.DefinitionImpl', null); //Switch off cache for hosted environment 
  $clean_html = $purifier->purify( $string );
  return $clean_html;
}
  }