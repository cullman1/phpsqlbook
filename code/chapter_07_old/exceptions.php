<?php
try {
  //Executes following lines correctly
  $host= "192.168.1.0";   
  $dbName = "mydb";       
  $userName="test_user";  
  $password="password";
  //Errors on next line then jumps to catch    
  $dbHost = new PDO("mysql:host=$serverName;dbname=$dbName",$userId,$password);         
  //Never executed    
  $query = "select thumbnail from media"; 
  $statement = $dbHost->prepare($qery);
  $statement->execute(); 
}
catch (PDOException $e) {
  //Code continues here
  echo "An error has occurred: " . $e; 
}
?>
