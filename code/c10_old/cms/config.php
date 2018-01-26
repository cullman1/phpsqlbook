<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once 'classes/model/Article.php';
  require_once 'classes/model/ArticleSummary.php';
  require_once 'classes/model/Category.php';
  require_once 'classes/model/User.php';

  require_once 'classes/service/CMS.php';
  require_once 'classes/service/ArticleManager.php';
  require_once 'classes/service/CategoryManager.php';
  require_once 'classes/service/UserManager.php';
  require_once 'classes/service/Utilities.php';
  require_once 'classes/service/Validate.php';

  require_once 'vendor/htmlpurifier-4.9.3/library/HTMLPurifier.auto.php';

 $database_config = array (
    'dsn' => 'mysql:host=207.246.241.90;dbname=387732_phpbook3;charset=utf8mb4',
    'username' => '387732_testuser3',
    'password' => 'phpbo^ok3belonG_3r'
);

  $cms              = new CMS($database_config);
  $articleManager   = $cms->getArticleManager();
  $categoryManager  = $cms->getCategoryManager();
  $userManager      = $cms->getUserManager();
  $is_logged_in     = $userManager->isLoggedIn();

  $page_title       = 'Creative Folk ';
  $meta_description = 'An agency for creatives';
  $site_name        = 'Creative Folk';

  ini_set( 'default_charset', 'UTF-8' );
  define('ROOT', '/phpsqlbook/code/c10/cms/');
define('ROOT2', '/phpsqlbook/cms-final/');