<?php
/* Include passwords and login details */
require_once('../includes/db_config.php');

// Open the file
$file = @fopen("names.txt", 'r'); 

// Add each line to an array
if ($file) {
   $row = explode("\n", fread($file, filesize("names.txt")));
   for ($i=0; $i<count($row)-1; $i++) {
        $items = explode(",", $row[$i]);
        //insert_user($items,$dbHost);
   }
   echo "Users table updated.";
   fclose($file);
   select_user($dbHost);
}

function insert_user($items, $dbHost) {
            $insert_user_sql = "INSERT INTO Users (full_name, email_address, total_log_ins, role_id) VALUES ('".$items[0]."','".$items[1]."',0, 1)";
            $insert_user_result = $dbHost->prepare($insert_user_sql);
            $insert_user_result->execute();
		    if($insert_user_result->errorCode()!=0) {  
                /* Insert failed */
                throw new Exception('Insert users failed');            
            }
}

function select_user($dbHost) {
    $select_user_sql = "Select * from Users";
    $select_user_result = $dbHost->prepare($select_user_sql);
    $select_user_result->execute();
    $select_user_result->setFetchMode(PDO::FETCH_ASSOC);
    echo "<table border=1><thead><tr><td>Name</td><td>Email</td><td>Log ins</td><td>Role</td></tr></thead><tbody>";
    while ($select_user_row = $select_user_result->fetch()) {  
        echo "<tr><td>".$select_user_row["full_name"]."</td><td>".$select_user_row["email_address"]."</td><td>".$select_user_row["total_log_ins"]."</td><td>".$select_user_row["role_id"]."</td></tr>";
    }
    echo "</tbody></table>";
}

?>


