<?php
class Validate {

  public static function isNumber($number, $min = 0, $max = 4294967295): bool{
    $options = array('options' => array('min_range'=>$min, 'max_range'=>$max));
    if (!filter_var($number, FILTER_VALIDATE_INT, $options)) {
      return FALSE;
    }
    return TRUE;
  }

  public static function isText($string, $min = 0, $max = 30000): bool {
    $length = mb_strlen($string);
    if (($length <= $min) or ($length >= $max)) {
      return FALSE;
    }
    return TRUE;
  }


  public static function isEmail($email): string {
    if (mb_strpos($email,'@') !== FALSE) {
      $split_email = explode('@', $email);
      $domain      = idn_to_ascii($split_email[1]);
      $email   = $split_email[0]. '@' . $domain;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return 'The email is not valid';
    }
    return '';
  }

  public static function isPassword($password): string {
    $result = '';
    if( (strlen($password)<8) OR (strlen($password)>32) ) { $result .= 'The password must be between 8 and 32 characters long. '; }
    if(!preg_match('/[A-Z]/', $password)) { $result .= 'This password did not contain any upper case letters. '; } // No A-Z found
    if(!preg_match('/[a-z]/', $password)) { $result .= 'This password did not contain any lower case letters. '; } // No a-z found
    if(!preg_match('/\d/', $password))    { $result .= 'This password did not contain any digits. '; } // No 0-9 found
    return $result;
  }



  public static function isHTML($string, $min = 0, $max = 4294967295) :bool {
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

  public static function isBoolean($boolean): bool {
    return self::isNumber($boolean, 0, 1);
  }

  public static function isId($number): string {
    $result = self::isNumber($number, 0, 999999);
    return (($result) ? '' : 'This is not a valid id.');
}

  public static function isArticleTitle($text): string {
    $result  = self::isText($text, 1, 254);
    return (($result) ? '' : 'Title should be between 1 and 254 characters.');
}

  public static function isSearchTerm($text): string {
    $result  = self::isHTML($text, 1, 64);
    return (($result) ? '' : 'The search term should be between 1 and 64 characters and should not contain HTML.');
}

  public static function isArticleSummary($text): string {
    $result  = self::isText($text, 1, 254);
    return (($result) ? '' : 'Article summary should be between 1 and 1000 characters.' );
}

  public static function isArticleContent($text): string {
    $result  = self::isHTML($text, 1, 100000);
    return (($result) ? '' : 'Article content should be between X and X characters.  
                          Permitted tags: &lt;p&gt; &lt;b&gt; &lt;i&gt; &lt;u&gt;.');
}

  public static function isArticlePublished($boolean): bool {
    return self::isNumber($boolean, 1, 1);
  }

  public static function isCategoryName($text): string {
    $result  = self::isText($text, 1, 24);
    return (($result) ? '' : 'This category name should be between 1 and 1000 characters.');
}
  public static function isCategoryDescription($text): string {
    $result  = self::isHTML($text, 1, 100000);
    return (($result) ? '' : 'Category description should be between  X and X characters. 
                          Permitted tags: &lt;p&gt; &lt;b&gt; &lt;i&gt; &lt;u&gt;.');
}

  public static function isUserName($name): string {
    $result  = self::isText($name, 1, 254);
    return (($result) ? '' : 'Name should be between 1 and 254 characters.');
}
}
