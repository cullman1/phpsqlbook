<?php class LayoutTemplate {
  private $registry;
  private $controller;
  private $pdo;
  private $action;
  private $parameters;
  public function __construct($controller,$action,$params, 
  $pdo) {
    $this->registry = Registry::instance();
    $this->pdo = $pdo;
    $this->controller = $controller;
    $this->action = $action;
    $this->parameters = $params;
    $this->registry->set('DbHandler',new DbHandler( $this->pdo));
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

public function getPart($part, $param="") {
 if (isset($_SESSION["user2"])) {
    $so = $_SESSION["user2"];
   $user_object = unserialize(base64_decode($so));
   $auth = $user_object->getAuthenticated(); 
  }
  $controller_modifier = $this->controller."_"; 
  switch($part) {
  case "comments":
 $controller_modifier = "";
 $dbh = $this->registry->get('DbHandler');
 $statement= $dbh->getArticleComments($this->pdo,$param);   
 $this->displayComments($statement);
  break;
  case "update":
case "status":
 $controller_modifier = $query = "";
 $dbhandler = $this->registry->get('DbHandler');
 if ($this->action=="success") {$query="success";}
  if ($this->action=="fail") {$query="fail";}
   $this->parseTemplate($dbhandler->getProfile($this->pdo,  
   $this->parameters[0]),"profile",$this->pdo,$part,$query);
   break;
  case "like":            
  $controller_modifier = "";
  $dbhandler = $this->registry->get('DbHandler');   
 if (isset($auth)) {
   $user_id = $auth;
  } else {
   $user_id = "0";
  }
 $this->parseTemplate($dbhandler->getAllLikes($this->pdo, 
  $user_id,$param),"like", $this->pdo);
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
    if ($this->controller=="login"|| 
    $this->controller=="profile") {
        if ($part=="header"||$part=="footer") {
         $controller_modifier = "recipes_"; 
        }
    }

   include("templates/".$controller_modifier.$part.".php"); 
    break;
  }
}

public function parseTemplate($recordset,$prefix,$pdo, $extra="content", $query="") {
$root="http://".$_SERVER['HTTP_HOST']."/cms";
$string = file_get_contents($root. "/classes/templates/".$prefix."_". $extra.".php?query=".$query); 
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

public function displayComments($recordset) {   
 $root="http://".$_SERVER['HTTP_HOST']."/cms";
 $string=file_get_contents($root."/classes/templates/comments_content.php");
 $regex = '#{{(.*?)}}#';
 preg_match_all($regex, $string, $matches);
 $opening_tag = strpos($string, "]]");
 $closing_tag = strpos($string, "]]", $opening_tag+1);    
 $string1= str_replace("[[for]]","", $string);
 $string2= str_replace("[[next]]","", $string1);
 $string3= str_replace("]","", $string2);
 $head_temp= substr($string3, 0, $opening_tag);
 $remain = $closing_tag - $opening_tag;
 $sub_temp2 = array();
 $count=0;
 if (!isset($_SESSION["user2"])) {
     $head_temp= str_replace("Add a comment","",$head_temp);
    }
 while ($row = $recordset->fetch()) {  
 $sub_temp=substr($string3,$opening_tag,$remain-9);
 if ($count==0) {
   foreach($matches[0] as $value) {           
   $replace= str_replace("{{","", $value);
    $replace= str_replace("}}","", $replace);
 $head_temp=str_replace($value,$row[$replace],$head_temp);
   }  
  echo $head_temp;
  } 
  preg_match_all($regex, $sub_temp, $inner_matches);
 foreach($inner_matches[0] as $value) {   
    $replace= str_replace("{{","", $value);
    $replace= str_replace("}}","", $replace);
    $sub_temp=str_replace($value,$row[$replace],$sub_temp);    
   $sub_temp2[$count] = $sub_temp;
  }
 $count++;
 }
 for ($i=0;$i<$count;$i++) {
  echo $sub_temp2[$i];
 }
 echo "</div></div></div>";
}

} ?>