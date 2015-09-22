 <?php require('../classes/registry.php');
  require('../classes/configuration.php');
  $registry = Registry::instance();
  $registry->set('conf', new Configuration());
  $db = $registry->get('configfile');
 $connect="mysql:host=".$db->getServerName() .";dbname=".$db->getDatabaseName();
  $pdo = new PDO($connect, $db->getUserName(), $db->getPassword()); 
  $pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
  $registry->set('pdo', $pdo);
  $dbHost =  $registry->get('pdo');
  if ($_REQUEST['user_id']=="0") {
    header('Location:../login/login-user.php');
  } else {    
    if($_REQUEST['liked']=="0") {
      $query = "INSERT INTO article_ like (user_id, article_id) VALUES (:userid, :articleid)";
    } else {
      $query = "DELETE FROM article_like WHERE user_id= :userid and article_id= :articleid";
    }
    $statment = $pdo->prepare($query);
    $statement->bindParam(":userid", $user_id);
    $statement->bindParam(":articleid", $article_id);
    $statment->execute();
    if ($statment->errorCode()!=0) {  die("Query failed"); }
    $return = $_SERVER["HTTP_REFERER"];
    header('Location:'.$return);
  }  ?>