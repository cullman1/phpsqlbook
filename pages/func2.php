<?php

//**************************************
//     First selection results     //
//**************************************
if($_GET['func'] == "show_column" && isset($_GET['func'])) { 
    show_column($_GET['drop_var']); 
}

function show_column($drop_var)
{  
    include_once('../includes/db_config.php');
    $drop_var = strtolower($drop_var);
    $query_sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$drop_var'";
    $query_sql_result = $dbHost->prepare($query_sql);
    $query_sql_result->execute();
    $query_sql_result->setFetchMode(PDO::FETCH_BOTH);         
	echo '<select id="column" onchange="showcolumn();" style="width:200px; display:block;"><option>*</option>';
    while($query_sql_row = $query_sql_result->fetch())
    {
       echo '<option>'. $query_sql_row["COLUMN_NAME"].'</option>';
    }
	echo '</select>';
}

function show_combo($drop_var)
{  
    include_once('../includes/db_config.php');
    $drop_var = strtolower($drop_var);
    $query_sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$drop_var'";
    $query_sql_result = $dbHost->prepare($query_sql);
    $query_sql_result->execute();
    $query_sql_result->setFetchMode(PDO::FETCH_BOTH);         

    while($query_sql_row = $query_sql_result->fetch())
    {
        echo '<input type="checkbox" class="checker" oncheck="showInput()" /><span>'. $query_sql_row["COLUMN_NAME"].'</span><br/>';
    }
}


?>