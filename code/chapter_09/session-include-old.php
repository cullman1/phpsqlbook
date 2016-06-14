<?php
session_start();

function check_array($currentpage) {
        $viewed = $_SESSION["viewed"];
        foreach($viewed as $value=>$row) {
            if ($row['url'] == $currentpage) {
                 unset($viewed[$value]);
            }
        }  
        return $viewed;
}

function add_current_page($currentpage, $currenttitle) {
    $current = array("url"=>$currentpage,"title"=>$currenttitle);
    if (isset($_SESSION["viewed"])) {
        //There is an array
        if (sizeof($_SESSION["viewed"]<4)) {
            //Less then 3 items so we need to add one
             array_push($_SESSION['viewed'],$current);
        } else {
            //3 items so remove the oldest and add one
             array_shift($_SESSION['viewed']);
             array_push($_SESSION['viewed'],$current);
        }
    } else {
        //There is no array so create an array and add item.
        $_SESSION['viewed'] = array();
        array_push($_SESSION['viewed'],$current);
    }
}

$page =  basename($_SERVER["PHP_SELF"]);
$pagename = explode(".", $page);
$title =  str_replace("session-","",$pagename[0]);
$title = ucwords($title);
if (isset($_SESSION["viewed"])) { 
   $_SESSION["viewed"]=  check_array($page);
}
add_current_page($page, $title);
?>