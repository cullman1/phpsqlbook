<?php class LayoutTemplate {
  private $registry;
  private $controller;
  private $pdo;
  private $action;
  private $parameters;
  public function __construct($controller, $action, $parameters ,$pdo) {
    $this->registry = Registry::instance();
    $this->controller = $controller;
    $this->action = $action;
    $this->parameters = $parameters;
    $this->registry->set('database',new Database());
  }

public function getPart($part, $param="") {
  if (isset($_SESSION["user2"])) {
   $so = $_SESSION["user2"];
    $user_object = unserialize(base64_decode($so));
    $auth = $user_object->getAuthenticated(); 
  }
  $controller_modifier = $this->controller."_"; 
   $dbhandler = $this->registry->get('database');   
  switch($part) {
   case "like":            
    $controller_modifier = "";
   
    if (isset($auth)) {
        $user_id = $auth;
    } else {
        $user_id = "0";
    }
    echo "like";
    $this->parseTemplate($dbhandler->getAllLikes($user_id,$param), "like", $this->pdo);
   break;
   case "author":
    $controller_modifier = "";

       echo "author";
    $this->parseTemplate($dbhandler->getAuthorName($param),"author",$this->pdo);
    break;
   case "update":
   case "status":
    $controller_modifier = $query = "";

    if ($this->action=="success") {$query="success";}
        if ($this->action=="fail") {$query="fail";}
           echo "profile";
    $this->parseTemplate($dbhandler->getProfile($this->parameters[0]),"profile",$this->pdo,$part,$query);
   break;
   default:
    if ($part=="search"||$part=="menu"||$part=="login_bar"){ 
      $controller_modifier = ""; 
    }
    if ($this->controller=="login" || $this->controller=="profile" || $this->controller=="register")
    {
        if ($part=="header"||$part=="footer") {
         $controller_modifier = "recipes_"; 
        }
    }
    
    include("templates/".$part.".php"); 
       
   break;
 }
}

public function getContentById($articleid) { 
 $dbhandler = $this->registry->get('database');  
    $this->parseTemplate($dbhandler->getArticleById($articleid), $this->controller, $this->pdo);

}

public function getContent($articleid) { 
 $dbhandler = $this->registry->get('database');  
    $this->parseTemplate($dbhandler->getArticleByName($this->parameters), $this->controller, $this->pdo);

}

public function parseTemplate($recordset,$prefix,$pdo, $extra="content", $query="") {
$root="http://".$_SERVER['HTTP_HOST']."/phpsqlbook/code/chapter_12/";
$string = file_get_contents($root. "/classes/templates/".$prefix. $extra.".php?query=".$query);  

 $regex = '#{{(.*?)}}#';
 $template="";
  preg_match_all($regex, $string, $matches);
 //  echo $recordset->queryString;  
  while($row = $recordset->fetch()) {

   // echo json_encode($row);  
    $template=$string;
   foreach($matches[0] as $value) {           
      $replace= str_replace("{{","", $value);
      $replace= str_replace("}}","", $replace);
    
      $template = str_replace($value,$row[$replace], $template);  
    }  
   
echo $template;  
  }						                    
}

} ?>
