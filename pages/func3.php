<?php

//**************************************
//     First selection results     //
//**************************************
if($_GET['func'] == "show_combo" && isset($_GET['func'])) { 
    show_combo($_GET['drop_var']); 
}



function show_combo($drop_var2)
{  
    include_once('../includes/db_config.php');
    $drop_var2 = strtolower($drop_var2);
    $count =0;
    $query_sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$drop_var2'";
    $query_sql_result = $dbHost->prepare($query_sql);
    $query_sql_result->execute();
    $query_sql_result->setFetchMode(PDO::FETCH_BOTH);   

    while($query_sql_row = $query_sql_result->fetch())
    {
        $count++;
        echo $query_sql_row["COLUMN_NAME"].',';
    }
    echo "last";
}


?>