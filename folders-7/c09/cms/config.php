<?php

  //error_reporting(E_ALL);
  //ini_set('display_errors', 1);

  require_once 'classes/model/Article.php';
  require_once 'classes/model/ArticleSummary.php';
  require_once 'classes/model/Category.php';
  require_once 'classes/model/User.php';

  require_once 'classes/service/CMS.php';
  require_once 'classes/service/ArticleManager.php';
  require_once 'classes/service/CategoryManager.php';
  require_once 'classes/service/UserManager.php';
  require_once 'classes/service/Validate.php';
  require_once 'vendor/html-purifier-4.9.3/library/HTMLPurifier.auto.php';

  include  dirname(__DIR__) .'../database-connection.php';
  include 'includes/ErrorMessages.php';

  $cms              = new CMS($database_config);



  $page_title       = 'Creative Folk ';
  $meta_description = 'An agency for creatives';
  $site_name        = 'Creative Folk';

  ini_set( 'default_charset', 'UTF-8' );
  define('ROOT', '/phpsqlbook/code/c09/cms/');

  