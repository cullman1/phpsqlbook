<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/service/CMS.php';
require_once 'classes/service/ArticleManager.php';
require_once 'classes/service/CategoryManager.php';
require_once 'classes/service/ImageManager.php';
require_once 'classes/service/UserManager.php';
require_once 'classes/service/Validate.php';


require_once 'classes/model/Article.php';
require_once 'classes/model/ArticleSummary.php';
require_once 'classes/model/Category.php';
require_once 'classes/model/Comment.php';
require_once 'classes/model/Media.php';
require_once 'classes/model/User.php';

$database_config = array (
    'dsn' => 'mysql:host=localhost:3306;dbname=phpbook4',
    'username' => 'root',
    'password' => ''
);

$cms              = new CMS($database_config);
$articleManager   = $cms->getArticleManager();
$categoryManager  = $cms->getCategoryManager();
$userManager      = $cms->getUserManager();
$mediaManager     = $cms->getImageManager();

$is_logged_in     = $userManager->isLoggedIn();
$my_profile       = FALSE;
$site_name        = 'Creative Folk';
$page_title       = $site_name . ' ';
$meta_description = 'An agency for creatives';

define('ROOT', '/phpsqlbook/cms-final/');
define('UPLOAD_DIR', 'uploads/');