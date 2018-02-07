<?php
class CMS {
  private $pdo;
  public $articleManager;
  public $categoryManager;
  public $userManager;

  public function __construct($configuration) {
      $this->pdo = new PDO(
          $configuration['dsn'],
          $configuration['username'],
          $configuration['password']);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->categoryManager = new CategoryManager($this->pdo);
      $this->articleManager = new ArticleManager($this->pdo);
      $this->userManager = new UserManager($this->pdo);
  }

  public static function redirect($page) {
      header( "Location: http://".$_SERVER['HTTP_HOST']. ROOT. $page );
      exit();
  }

 public static function createSlug($text) {
    $text = mb_strtolower($text);
    $text = trim($text);
    $text = transliterator_transliterate('Any-Latin; Latin-ASCII' , $text);
    $text = preg_replace('/[^A-z0-9 ]+/', '', $text);
    $text = preg_replace('/ /', '-', $text);
    return $text;
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

  public static function createPagination($count, $show, $from) {
    $total_pages  = ceil($count / $show);       // Total matches
    $current_page = ceil($from / $show) + 1;    // Current page
    $result  = '<nav aria-label="Page navigation"><ul class="pagination">';
    if ($total_pages > 1) {
      for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
          $result .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
          $result .= '<li class="page-item"><a class="page-link"  href="?show=' . $show . '&from=' . (($i-1) * $show) . '">';
          $result .= $i . '</a></li>';
        }
      }
    }
    $result .= '</ul></nav>';
    return $result ;
  }


}