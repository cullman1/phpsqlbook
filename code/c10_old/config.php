<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1);


  require_once 'cms/classes/service/CMS.php';



 $database_config = array (
    'dsn' => 'mysql:host=207.246.241.90;dbname=387732_phpbook3;charset=utf8mb4',
    'username' => '387732_testuser3',
    'password' => 'phpbo^ok3belonG_3r'
);

  $cms              = new CMS($database_config);


  $page_title       = 'Creative Folk ';
  $meta_description = 'An agency for creatives';
  $site_name        = 'Creative Folk';

  ini_set( 'default_charset', 'UTF-8' );
  define('ROOT', '/phpsqlbook/code/c10/cms/');
define('ROOT2', '/phpsqlbook/cms-final/');