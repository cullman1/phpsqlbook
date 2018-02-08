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
      exit;
  }

    public function formatDate($timestamp) {
        return date('jS F Y', strtotime($timestamp));
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