<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/model/Article.php';
require_once 'classes/model/ArticleSummary.php';
require_once 'classes/model/Category.php';
require_once 'classes/model/User.php';

require_once 'classes/service/ArticleManager.php';
require_once 'classes/service/CategoryManager.php';
require_once 'classes/service/CMS.php';
require_once 'classes/service/UserManager.php';

$database_config = array (
    'dsn' => 'mysql:host=localhost;dbname=cms',
    'username' => 'root',
    'password' => ''
);

$page_title       = 'Creative Folk ';
$meta_description = 'An agency for creatives';