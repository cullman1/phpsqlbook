<?php
try {
   /* Step 1 Connection */
    $connection = new PDO("mysql:host=mysql51-036.wc1.dfw1.stabletransit.com;dbname=387732_phpbook1", "387732_phpbook1", "F8sk3j32j2fslsd0");

   /* Step 2 Query */
   $select_sql_statement = 'SELECT full_name, total_log_ins  FROM Users WHERE user_id=1001';

   /* Step 3 Execution */  
   $select_sql_result = $connection->prepare($select_sql_statement);
   $select_sql_result->execute();

   /* Step 4 Display results */
   $select_sql_array = $select_sql_result->fetch(PDO::FETCH_ASSOC);
   echo $select_sql_array["full_name"]." - ".$select_sql_array["total_log_ins"]. "<br/>";
}
catch (Exception $e) 
{
    /* Step 4 Or display an error message */
    echo $e->getMessage();
}
?>