<?php error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require('../classes/registry.php');
  require('../classes/configuration.php');
  $registry = Registry::instance();
  $registry->set('configfile', new Configuration());
  $db = $registry->get('configfile');
  $connect="mysql:host=".$db->getServerName() .";dbname=".$db->getDatabaseName();
  $pdo = new PDO($connect, $db->getUserName(), $db->getPassword()); 
  $pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
  $registry->set('pdo', $pdo);
  $dbHost =  $registry->get('pdo');
  if ($_REQUEST['user_id']=="0") {
    header('Location:../../cmsfull/login/login-user.php');
  } else {    
    if($_REQUEST['liked']=="0") {
      $query = "INSERT INTO article_like (user_id, article_id) VALUES (:userid, :articleid)";
    } else {
      $query = "DELETE FROM article_like WHERE user_id= :userid and article_id= :articleid";
    }
    $statement = $pdo->prepare($query);
    $statement->bindParam(":userid", $_REQUEST["user_id"]);
    $statement->bindParam(":articleid", $_REQUEST["article_id"]);
    $statement->execute();
    if ($statement->errorCode()!=0) {  die("Query failed"); }
    $return = $_SERVER["HTTP_REFERER"];
    header('Location:'.$return);
  }  ?>