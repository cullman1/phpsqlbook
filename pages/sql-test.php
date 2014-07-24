
<?php include '../includes/header-site.php' ?>

<?php 
$display_string = "";
      if (isset($_REQUEST["sqlquery"]))
      {
          try
          {
              $query_sql = $_REQUEST["sqlquery"];
              $query_sql_result = $dbHost->prepare($query_sql);
              $query_sql_result->execute();
              $query_sql_result->setFetchMode(PDO::FETCH_BOTH);
              
              $query_sql = strtolower($query_sql);
              $exploded = explode(" ", $query_sql);
              $count = count($exploded)-1;
              for ($j=0; $j<=$count; $j++)
              {
                  if ($exploded[$j]=="from")
                  {
                      $table_name = $exploded[$j+1];
                  }
              }
              
              $columnname_sql = "DESCRIBE ". $table_name;
              $columnname_result = $dbHost->prepare($columnname_sql);
              $columnname_result->execute();
              $columnname_row = $columnname_result->fetchAll(PDO::FETCH_COLUMN);
              
              $colcount = $query_sql_result->columnCount();
              $columncount = count($columnname_row)-1;
              $display_string .= "<tr>";
              for ($i=0;$i<$columncount;$i++)
              {
                  $display_string .= "<td><b style='font-size:11pt'>".$columnname_row[$i] . "</b></td> ";
              }
              $display_string .= "</tr>";
              while($row = $query_sql_result->fetch())
              {
                  $display_string .= "<tr>";
                  for ($i=0;$i<$colcount-1;$i++)
                  {
                      $display_string .=  "<td style='font-size:11pt'>".$row[$i] . "</td>";
                  }
                  
                  $display_string .= "</tr>";
              }
          }
          catch (PDOException $e)
          {
              $display_string = "<tr style='vertical-align:top; '><td><b style='font-size:11pt'>".$e->getMessage()."</b></td></tr>";
            
          }
      }
?>
 <div class="small_box">
    <div class="small_box_top">
        SQL Query
    </div>
    <form id="form1" method="post" action="sql-test.php">
        <div class="pad">
  		    <textarea id="sqlquery" name="sqlquery" style="width: 600px; height:80px"> <?php if (isset($_REQUEST["sqlquery"]))
      { 
          echo $_REQUEST["sqlquery"];
               } ?></textarea>
            <br /><br />
            <input id="submit" type="submit" value="Submit Query" />
            <br /><br />
            <table id="sqlresult" name="sqlresult" style="height:350px; background-color:lightgoldenrodyellow" >
                 <?php if (isset($_REQUEST["sqlquery"]))
      { 
                echo $display_string;
               } ?>
            </table>
        </div>
    </form>
 </div>

<?php include '../includes/footer-site.php' ?>