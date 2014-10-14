<?php
try {
/* Step 1 Connection */
$serverName = "mysql51-036.wc1.dfw1.stabletransit.com";
$userName = "387732_phpbook1";
$password = "F8sk3j32j2fslsd0"; 
$databaseName = "387732_phpbook1";
$connection = new PDO("mysql:host=$serverName;dbname=$databaseName", $userName, $password);

/* Step 2 Query */
$select_sql_statement = "SELECT * FROM user WHERE user_id=1";


   /* Step 3 Execution */  
   $select_sql_result = $connection->prepare($select_sql_statement);
   $select_sql_result->execute();

   /* Step 4 Display Results */
   $select_sql_array = $select_sql_result->fetch(PDO::FETCH_ASSOC);
   echo $select_sql_array["full_name"]." - ".$select_sql_array["log_in_number"]. "<br/>";
}
catch (Exception $e) 
{
    /* Step 4 Or Display Error Message*/
    echo $e->getMessage();
}
?>