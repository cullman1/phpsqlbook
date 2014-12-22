<?php 
require_once('authenticate.php'); 

/* Include passwords and login details */
require_once('../includes/db_config.php');
include '../includes/header-register.php';
/* Query SQL Server for checking user details. */
$select_user_sql = "SELECT * from user WHERE email ='".$_SESSION['email'];
$select_user_result = $dbHost->prepare($select_user_sql);
$select_user_result->execute();
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);

  	/* Redirect to original page */
while($select_user_row = $select_user_result->fetch()) {
    echo "<br/>General Link 1";
    echo "<br/>General Link 2";
    if ($select_user_row["role_id"]==1)
    {
        echo "<br/>Admin Only Link 3";
        echo "<br/>Admin Only Link 4";
    }
}

include '../includes/footer.php';
?>