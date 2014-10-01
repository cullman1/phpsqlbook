<?php

// Step 1 – create a connection using PDO
try
{
    $serverName = "72.32.1.169";
    $userName = "387732_phpbook1";
    $password = "F8sk3j32j2fslsd0"; 
    $databaseName = "387732_phpbook1";
    $dbHost = new PDO("mysql:host=$serverName;
                        dbname=$databaseName", 
                        $userName, 
                        $password);
    $dbHost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch (PDOException $e)
{
    echo $e->getMessage();
}
/* Step 2 Create a query */
$select_article_sql = "SELECT article_id, title, content, date_posted, date_published FROM article WHERE user_id = ". $_REQUEST["user_value"];

/* Step 3 Execute the query */
$select_article_result = $dbHost->prepare($select_article_sql);
$select_article_result->execute();

$select_article_result->setFetchMode(PDO::FETCH_ASSOC);
/* Step 4 – Display the query */
echo "<table>";
while($row = $select_article_result ->fetch())
{
echo "<tr><td>". $row ['title'] ."</td>"; 
  	echo "<td>".date("F j, Y, g:i a", strtotime($row['date_posted'])) . "</td>"; 
echo "<td>".$row['content']."</td></tr>"; 
 }
echo "</table>";
?>

