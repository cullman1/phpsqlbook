<?php

class Validate {

const MEDIATYPE_jpeg = 'image/jpeg';
const MEDIATYPE_png = 'image/png';
const MEDIATYPE_gif = 'image/gif';

  public static function isNumber($number, $min = 0, $max = 4294967295) {
      if ( (!filter_var($number, FILTER_VALIDATE_INT)) or (($number < $min) or ($number > $max)) ) {
      return FALSE;
    }
    return TRUE;
  }

  public static function isText($string, $min = 0, $max = 30000){
    $length = strlen($string);
    if (($length <= $min) or ($length >= $max)) {
      return FALSE;
    }
    return TRUE;
  }

  public static function isEmail($email) {
     return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public static function isPassword($password) {
    if( (strlen($password)<8) OR (strlen($password)>32) ) { echo"1";$error = TRUE; }                    // Less than 8 characters
    if(preg_match_all('/[A-Z]/', $password)<1) {  echo"2";$error = TRUE; } // < 1 x A-Z return FALSE
    if(preg_match_all('/[a-z]/', $password)<1) {  echo"3";$error = TRUE; } // < 1 x a-z return FALSE
    if(preg_match_all('/\d/', $password)<1)    {  echo"4";$error = TRUE; } // < 1 x 0-9 return FALSE
    if (isset($error)) {
      return FALSE;
    }
    return TRUE;
  }

  public static function isConfirmPassword($password, $confirm) {
      return ( ($password != $confirm) ? FALSE : TRUE ); 
  }

  public static function isDate($date_array) {
    return checkdate($date_array[0], $date_array[1], $date_array[2]);
  }

  public static function isDateAndTime($date_time) {
    $date_time_string = $date_time[2] . '-' . $date_time[0] . '-' . $date_time[1] . ' ' . $date_time[3] . ':' . $date_time[4];
    $date_object = date_create($date_time_string);
    if (!$date_object) {
      return FALSE;
    }
    return TRUE;
  }

  public static function isFilename($filename) {
    $result = preg_replace('/[^A-z0-9 \.\-\_]/', '', $filename); /// add other characters allowed here
    if ($result != $filename ) {
      return FALSE;
    }
    return $TRUE;
  }

  public static function isAllowedCharacters($text) {
    $result = preg_replace('/[^A-z0-9 \.,!\?\'\"#\$%&*\(\)\+\-\/]/', '', $title); /// add other characters allowed here
    if ($result != $text ) {
      return FALSE;
    }
    return $TRUE;
  }



  public static function isAllowedExtension($filename, $filetypes) {         // Check file extension
    $error = '';                                                 // Blank error message
    if (!preg_match('/.(jpg|jpeg|png|gif)$/', $filename) ) {    // If not file extension
      $error .= 'Your filename must end with .jpg .jpeg .png or .gif'; // Error message
    }
    return $error;                                                // Return error
  }

  public static function isAllowedMediaType($mediatype) {                       // Check media type
    $allowed = Array(self::MEDIATYPE_jpeg,self::MEDIATYPE_png, self::MEDIATYPE_gif); // Allowed
    if (in_array($mediatype, $allowedmedia)) {            // If type is in list
      $error = '';                                            // Blank error message
    } else {                                                    // Otherwise
      $error = 'You can only upload jpg, jpeg, png, and gif formats.'; // Error message
    }
    return $error;                                              // Return error
  }

  public static function sanitizeFileName($file) {                         // Clean file name
    $file = preg_replace('([\~,;])',       '-', $file);    // Replace \ , ; with -
    $file = preg_replace('([^\w\d\-_~.])',  '', $file);    // Remove unwanted characters
    return $file;                                          // Return cleaned name
  }

  public static function isName($name) {
    $error = '';
    $name = trim($name);

    if ( (self::stringLength($name, 1, 255)) == FALSE ) {
      $error = 'Please enter between 1 and 255 characters.<br>';
    }

    $result = preg_replace('/[^A-z\'\-]/', '', $name); /// add other characters allowed here
    if ($result != $name ) {
      $error .= 'You can only use the following characters A-Z, a-z, &#39; -<br>';
    }

    return $error;
  }



  // None of these are needed any more
  public static function isCategory($category) {
    $errors = array('id' => '', 'name'=>'', 'description'=>'');             // Form errors
    if ($category->id != '') {
      $errors['id']   = self::isID($category->id);
    }
    $errors['name']        = self::isCategoryName($category->name);
    $errors['description'] = self::isCategoryDescription($category->description);
    return $errors;
  }

  public static function isArticle($article) {
    if ($article->id != 'new') {
      $errors['id']   = $this->isID($Article->id);
    }
    $errors['title']       = self::isArticleTitle($article->title);
    $errors['content']     = self::isArticleContent($article->content);
    //		$errors['published']   = self::isArticleContent($article->published);
    $errors['category_id'] = self::isID($article->category_id);
    $errors['user_id']     = self::isID($article->user_id);
    //		$errors['media_id']    = self::isID($article->media_id);
    return $errors;
  }

  public static function isUser($user) {
    if ($User->id != 'new') {
      $errors['id']   = $this->isID($User->id);
    }
    $errors['forename'] = self::isName($user->forename);
    $errors['surname']  = self::isName($user->surname);
    $errors['email']    = self::isEmail($user->email);
    $errors['password'] = self::isPassword($user->password);
    return $errors;
  }

  public static function isMedia($media) {                                  // Return cleaned name
    if ($Media->id != 'new') {                                // If not new media
      $errors['id']   = $this->isID($Media->id);              // Validate id
    }
//    self::filename    = sanitize_file_name(self::filename);          // Clean filenamne
    $errors['title']  = self::isMediaTitle($media->title);           // Check title
    $errors['alt']    = self::isMediaAlt($media->alt);               // Check alt text
    $errors['file']  .= self::isAllowedFileExtension($media->filename); // Check ext
    $errors['file']   = self::isAllowedMediaType($media->mediaType); // Check type
    $errors['file']  .= self::isWithinFileSize($media->filesize);    // Check size
    return $errors;                                                   // Return array
  }

  public static function isGallery($gallery) {
    if ($gallery->id != 'new') {
      $errors['id']   = $this->isID($Gallery->id);
    }
    $errors['name'] = self::isGalleryName($gallery->name);
    $errors['mode'] = self::ismode($gallery->mode);
    return $errors;
  }
}