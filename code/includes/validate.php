<?php
class Validate {

function numberRange($number, $min = 0, $max = 4294967295) {
  if ( ($number < $min) or ($number > $max) ) {
    return FALSE;
  }
  return TRUE;
}

function stringLength($string, $min = 0, $max = 255) {
  $length = strlen($string);
  if (($length < $min) or ($length > $max)) {
    return FALSE;
  }
  return TRUE;
}

function filename($filename) {
  $error = '';
  if ($this->stringLength($filename, 5, 50) != TRUE) {
    $error = 'Your filename is not long enough.<br>';
  }
  $result = preg_replace('/[^A-z0-9 \.\-\_]/', '', $filename); /// add other characters allowed here
  if ($result != $filename ) {
    $error .= 'You can only use the following characters A-Z, a-z, and numbers 0-9 and . , ! ? &#39; &quot; @ # $ % &amp; * ( ) / \ - .<br>';
  }
  return $error;
}


function isID($id) {
  if ( (!filter_var($id, FILTER_VALIDATE_INT)) or (!$this->numberRange($id, 1, 4294967295)) ) {
        return 'We could not find this item.<br>';
      }
  return '';
}

function isArticleTitle($title) {
  $error = '';
  $title = trim($title);

  if ( ($this->stringLength($title, 3, 255)) == FALSE ) {
    $error = 'Please enter between 3 and 255 characters.<br>';
  }

  $result = preg_replace('/[^A-z0-9 \.,!\?\'\"#\$%&*\(\)\+\-\/]/', '', $title); /// add other characters allowed here
  if ($result != $title ) {
    $error .= 'You can only use the following characters A-Z, a-z, and numbers 0-9 and . , ! ? &#39; &quot; @ # $ % &amp; * ( ) / \ - .<br>';
  }

  return $error;
}

function isArticleContent($article) {
  $error = '';
  if ( ($this->stringLength($article, 1, 30000)) == FALSE ) {
    $error = 'Your article cannot be longer than 30,000 characters.<br>';
    $error .= 'It is currently ' . strlen($article) . ' characters.<br>';
  }
  return $error;
}

function isCategoryName($name) {
  return $this->isArticleTitle($name);
}

function isCategoryTemplate($filename) {
  $error = $this->filename($filename);
  if (! preg_match('/.php$/', $filename) ) {
    $error .= 'Your filename must end with .php';
  }
  return $error;
}

function isMediaTitle($title) {
  return $this->isArticleTitle($title);
}

function isMediaName($name) {
  return $this->isArticleTitle($name);
}

function isMediaAlt($alt) {
  return $this->isArticleTitle($alt);
}

function isMediaFilename($filename) {
  $error = $this->filename($filename);
  if (!preg_match('/.(jpg|jpeg|png|gif)$/', $filename) ) {
    $error .= 'Your filename must end with .jpg .jpeg .png or .gif';
  }
  return $error;
}

function isMimetype($mimetype) {
  if(!preg_match('/(image\/jpg|image\/jpeg|image\/png|image\/gif)/i', $mimetype)) {
    return 'You can only upload jpg, jpeg, png, and gif formats.';
  }
  return '';
}

function isEmail($email) {
  if ( (filter_var($email, FILTER_VALIDATE_EMAIL)) == FALSE ) {
    return 'Please enter a valid email address.<br>';
  }
  return '';
}

function isPassword($password) {
  if( (strlen($password)<8) OR (strlen($password)>32) ) { $error = TRUE; }                    // Less than 8 characters
  if (isset($error)) {
    return 'Your password cannot be blank.';
  }
  return '';
}

function isStrongPassword($password) {
  if( (strlen($password)<8) OR (strlen($password)>32) ) { $error = TRUE; }                    // Less than 8 characters
  if(preg_match_all('/[A-Z]/', $password)<1) { $error = TRUE; } // < 1 x A-Z return FALSE
  if(preg_match_all('/[a-z]/', $password)<1) { $error = TRUE; } // < 1 x a-z return FALSE
  if(preg_match_all('/\d/', $password)<1)    { $error = TRUE; } // < 1 x 0-9 return FALSE
  if (isset($error)) {
    return 'Your password must contain two uppercase letters, 2 lowercase letters, and a number. It must be between 8 and 32 characters.';
  }
  return '';
}

function isDate($date_array) {
  return (checkdate($date_array[0], $date_array[1], $date_array[2]) ? '' : 'Please enter a valid date');
}

function isDateAndTime($date_time) {
  $date_time_string = $date_time[2] . '-' . $date_time[0] . '-' . $date_time[1] . ' ' . $date_time[3] . ':' . $date_time[4];
  $date_object = date_create($date_time_string);

  if ($date_object == FALSE) {
    return 'Please enter a valid date and time';
  }
  return '';
}
}
?>
