<?php
require_once('../classes/user.php');
session_start();
$user_object = "";
if (!isset($_SESSION["user"])) 
            { 
                $so = $_SESSION["user"];
                $user_object = unserialize($so);
                if(empty($user_object->authenticated)) 
                { 
	                header('Location:../login/login-admin.php');
                }
}
?>

/* admin/add-article.php
   includes/comments-control.php
   includes/reply-box.php
   includes/reply-box-parent.php
   pages/add-comment.php
   pages/add-comment-text.php */