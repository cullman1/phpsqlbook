<?php

class Validate {

  public static function isNumber($number, $min = 0, $max = 4294967295) {
    if ( (!filter_var($number, FILTER_VALIDATE_INT)) or (($number < $min) or ($number > $max)) ) {
      return FALSE;
    }
    return TRUE;
  }

  public static function isText($string, $min = 0, $max = 30000){
    $length = mb_strlen($string);
    if (($length <= $min) or ($length >= $max)) {
      return FALSE;
    }
    return TRUE;
  }

   public static function isName($string, $min = 0, $max = 100){
     $result = preg_replace('/<[^>]*>/', '',  $string); 
     $result = trim($result);
     $length = mb_strlen($string);
    if (($length <= $min) or ($length >= $max) or ($result != $string )) {
      return FALSE;
    }
    return TRUE;
  }


  public static function isChecked($value) {
    return ($value == 'on' ? TRUE : FALSE);
  }

  public static function isEmail($email) {
   // if (!empty($email) && (mb_strpos($email,'@')!==false)) {
  //    $email = Utilities::punyCodeDomain($email); 
  //  }
   if ( (! filter_var($email, FILTER_VALIDATE_EMAIL))) {
       return FALSE;
    }
    return TRUE;
  }

  public static function isPassword($password) {
    if( (mb_strlen($password)<8) OR (mb_strlen($password)>32) ) { $error = TRUE; }                    // Less than 8 characters
    if(preg_match_all('/[A-Z]/', $password)<1) { $error = TRUE; } // < 1 x A-Z return FALSE
    if(preg_match_all('/[a-z]/', $password)<1) { $error = TRUE; } // < 1 x a-z return FALSE
    if(preg_match_all('/\d/', $password)<1)    { $error = TRUE; } // < 1 x 0-9 return FALSE
    if (isset($error)) {
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

    public static function isAllowedFilename($text) {
    $result = preg_replace('/[^A-z0-9 \.,!\?\'\"#\$%&*\(\)\+\-\/]/', '', $text); /// add other characters allowed here
    if ($result != $text ) {
      return FALSE;
    }
    return TRUE;
  }


  public static function isAllowedExtension($filename) {       // Check file extension
    $filename = mb_strtolower($filename);
    if (!preg_match('/.(jpg|jpeg|png|gif)$/', $filename) ) {    // If not file extension
      return FALSE;
    }
    return TRUE;                                               // Return error
  }

  public static function isAllowedMediaType($file) {      // Check media type
    //Must include extension=php_fileinfo.dll first in php.ini   
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $fileContents = file_get_contents($file);
    $mimeType = $finfo->buffer($fileContents);   
    $allowedmedia_types = array('image/jpeg', 'image/png', 'image/gif'); // Allowed
    if (!in_array($mimeType, $allowedmedia_types)) {          // If type is in list
      return FALSE;                                            // Blank error message
    }
    return TRUE;
  }

  public static function isWithinFileSize($size, $max) {        // Check file size
    if ($size > $max) {                                         // If size too big
      return FALSE;
    }
    return TRUE;                                                // Return error
  }

  // This is in article manager too at the moment..
  public static function sanitizeFileName($file) {                         // Clean file name
    $file = transliterator_transliterate("Latin-ASCII", $file); //Do we transliterate?
    $file = preg_replace('([\~,;])',       '-', $file);    // Replace \ , ; with -
    $file = preg_replace('([^\w\d\-_~.])',  '', $file);    // Remove unwanted characters
    return $file;                                          // Return cleaned name
  }

  public static function sanitizeName($name) {                         // Clean file name
    $name = preg_replace('([\~,;])',       '-', $file);    // Replace \ , ; with -
    $name = preg_replace('([^\w\d\-_~.])',  '', $file);    // Remove unwanted characters
    return $name;                                          // Return cleaned name
  }

}