<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/service/CMS.php';
require_once 'classes/service/ArticleManager.php';
require_once 'classes/service/CategoryManager.php';
require_once 'classes/service/ImageManager.php';
require_once 'classes/service/UserManager.php';
require_once 'classes/service/Validate.php';
require_once 'classes/service/Utilities.php';

require_once 'classes/model/Article.php';
require_once 'classes/model/ArticleSummary.php';
require_once 'classes/model/Category.php';
require_once 'classes/model/Comment.php';
require_once 'classes/model/Image.php';
require_once 'classes/model/User.php';

require_once 'vendor/html-purifier-4.9.3/library/HTMLPurifier.auto.php';

/*$database_config = array (
    'dsn' => 'mysql:host=localhost:3306;dbname=phpbook4;charset=utf8mb4',
    'username' => 'root',
    'password' => ''
);*/
define('ROOT', '/phpsqlbook/cms-update/');
define('UPLOAD_DIR', 'uploads/');

//mariadb-135.wc1.phx1.stabletransit.com;
$database_config = array (
    'dsn' => 'mysql:host=207.246.241.138;dbname=387732_phpbook4;port=3306;charset=utf8',
    'username' => '387732_testuser4',
    'password' => 'CVz-MhH-Yju-4Xc'
);

$cms              = new CMS($database_config);
$articleManager   = $cms->getArticleManager();
$categoryManager  = $cms->getCategoryManager();
$userManager      = $cms->getUserManager();
$imageManager     = $cms->getImageManager();

$is_logged_in     = $userManager->isLoggedIn();
$my_profile       = FALSE;
$site_name        = 'Creative Folk';
$page_title       = $site_name . ' ';
$meta_description = 'An agency for creatives';

ini_set( 'default_charset', 'UTF-8' );
