<?php
require_once('../classes/user.php');
session_start();
$user_object = "";
if (isset($_SESSION["user2"])) 
            { 
                $so = $_SESSION["user2"];
                $user_object = unserialize($so);
                $auth = $user_object->getAuthenticated();
                if(empty($auth)) 
                { 
                    
	                header('Location:../login/login-admin.php');
                }
}
            else
            {
           
                header('Location:../login/login-admin.php');   
            }

/* admin/add-article.php
includes/comments-control.php
includes/reply-box.php
includes/reply-box-parent.php
pages/add-comment.php
pages/add-comment-text.php */
?>