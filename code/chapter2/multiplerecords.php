<?php
try {
   /* Step 1 Connection */
   $connection = new PDO("mysql:host=tests.com;dbname=simplecms", "testuser", "PHPPassword");

   /* Step 2 Query */
   $select_sql_statement = 'SELECT full_name, log_in_number FROM users';

   /* Step 3 Execution */  
   $select_sql_result = $connection->prepare($select_sql_statement);
   $select_sql_result->execute();

   /* Step 4 Display results */
   while ($select_sql_row = $select_sql_result->fetch(PDO::FETCH_ASSOC))
   {
   	echo $select_sql_row["full_name"]." - ".$select_sql_array["log_in_number"]. "<br/>";
   }
}
catch (Exception $e) 
{
    /* Step 4 Or display an error message */
    echo $e->getMessage();
}
?>