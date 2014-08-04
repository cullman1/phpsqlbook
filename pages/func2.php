<?php

//**************************************
//     First selection results     //
//**************************************
if($_GET['func'] == "show_column" && isset($_GET['func'])) { 
    show_column($_GET['drop_var']); 
}

function show_column($drop_var)
{  
    require_once('../includes/db_config.php');
    $drop_var = strtolower($drop_var);
              $query_sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$drop_var'";
              $query_sql_result = $dbHost->prepare($query_sql);
              $query_sql_result->execute();
              $query_sql_result->setFetchMode(PDO::FETCH_BOTH);
             
              
	
	echo '<select id="column" onchange="showWhere();" style="width:200px">                <option>None</option>';

		   while($query_sql_row = $query_sql_result->fetch())
              {
                echo '<option>'. $query_sql_row["COLUMN_NAME"].'</option>';
              }
	
	echo '</select> ';
}
?>