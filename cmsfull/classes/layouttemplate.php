<?php class LayoutTemplate {
  private $registry;
  private $controller;
  private $pdo;
  public function __construct($controller, $action, 
   $parameters ,$pdo) {
    $this->registry = Registry::instance();
    $this->pdo = $pdo;
    $this->controller = $controller;
    $this->action = $action;
    $this->parameters = $parameters;
    $this->registry->set('DbHandler',new DbHandler(
     $this->pdo));
  }

  public function getPart($part, $param="") {
 if (isset($_SESSION["user2"])) {
    $so = $_SESSION["user2"];

   $user_object = unserialize($so);
   //print_r( $user_object );
   $auth = $user_object->getAuthenticated(); 
  }
  $controller_modifier = $this->controller."_"; 
  switch($part) {
  case "like":            
  $controller_modifier = "";

  $dbhandler = $this->registry->get('DbHandler');   
 if (isset($auth)) {
   $user_id = $auth;
    
  } else {
   $user_id = "0";
  }
 $this->parseTemplate($dbhandler->getAllLikes($this->pdo, $user_id,$param), "like", $this->pdo);
  break;
  case "author":
  $controller_modifier = "";
  $dbhandler = $this->registry->get('DbHandler');
  $this->parseTemplate($dbhandler->getAuthorName($this->pdo,$param),"author",$this->pdo);

  break;
  default:
   if ($part=="search"||$part=="menu"||$part=="login_bar"){ 
      $controller_modifier = ""; 
    }
   include("templates/".$controller_modifier.$part.".php"); 
    break;
  }
}

public function getContent($articleid) { 
 $dbhandler = $this->registry->get('DbHandler');  
 if(is_numeric($this->parameters[0]) || $this-> 
   parameters[0]=="" || isset($_GET["search"] )) {
    $this->parseTemplate($dbhandler->getArticleById($this->pdo,$articleid),$this->controller,$this->pdo);
  } else {        
  $this->parseTemplate($dbhandler->getArticleByName($this->pdo, $this->parameters ), $this->controller, $this->pdo);
  }
}

public function parseTemplate($recordset,$prefix,$pdo) {
 
$root="http://".$_SERVER['HTTP_HOST']."/".$this->controller;
 
$string = file_get_contents($root. "/classes/templates/".$prefix."_content.php");  

 $regex = '#{{(.*?)}}#';
 $template="";
  preg_match_all($regex, $string, $matches);
  while($row = $recordset->fetch()) {
    $template=$string;
   foreach($matches[0] as $value) {           
      $replace= str_replace("{{","", $value);
      $replace= str_replace("}}","", $replace);
      $template = str_replace($value,$row[$replace], 
      $template);  
    }  
   
echo $template;  
  }						                    
}

} ?>
