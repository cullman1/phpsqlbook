<?php
class LayoutTemplate {
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
    $auth = $user_object->getAuthenticated();
   }                                     
   $controller_modifier = $this->controller."_";                                                        
   $querystring="";                                                                                                              
   switch($part) {                                                                                                                                      
   default:					
    if ($part=="search"||$part=="menu"||$part=="login_bar"){       
      $controller_modifier = ""; 		 
    }    
//echo "templates/".$controller_modifier.$part.".php";					            
    include("templates/".$controller_modifier.$part.".php");             
    break;        						  
}  
}
    public function getContent($articleid) { 
        $dbhandler = $this->registry->get('DbHandler');  
        if(is_numeric($this->parameters[0]) || $this->parameters[0]=="" || isset($_REQUEST["search"] )) {
          $this->parseTemplate($dbhandler->getArticleById($this->pdo, $articleid),$this->controller,$this->pdo);
        }
        else {        
          $this->parseTemplate($dbhandler->getArticleByName($this->pdo, $this->parameters ), $this->controller, $this->pdo);
        }
    }
  
public function parseTemplate($recordset, $controller, $pdo) {
  echo "Doc root: ". $_SERVER['HTTP_HOST'];
  $root = "http://".$_SERVER['HTTP_HOST'] . "/" . $controller;
 $string = file_get_contents($root. "/classes/templates/".$controller."_content.php");
  $regex = '#{{(.*?)}}#';
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

}
?>