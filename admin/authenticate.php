<?php
require_once('../classes/user.php');
session_start();
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