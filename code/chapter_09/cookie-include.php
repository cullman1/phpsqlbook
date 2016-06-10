<?php
$username = filter_input(INPUT_COOKIE, 'username');
$color = filter_input(INPUT_COOKIE, 'colorChoice');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $color = filter_input(INPUT_POST, 'color');
    if($username != null ){   
        setcookie("username","",time() - (60* 1),"/","test1.phpandmysqlbook.com");  
        setcookie("username",$username, time() + (60* 1),"/","test1.phpandmysqlbook.com");  
    }    
    if ($color != null) {
        setcookie("colorChoice","",time() - (60* 1),"/","test1.phpandmysqlbook.com");  
        setcookie("colorChoice",$color, time() + (60* 1),"/","test1.phpandmysqlbook.com");  
    }
    include("style1.php");       
 } else if (isset($_COOKIE["colorChoice"])) {
       include("style.php");
 }
?>