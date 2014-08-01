
<?php include '../includes/header-site.php' ?>
<style>
    label { width: 200px; float: left; margin: 0 20px 0 0; }
span { display: block; margin: 0 0 3px; font-size: 1.2em; font-weight: bold; }
select { width: 150px; border: 1px solid #000; padding: 5px; }
    .hidetable, .hidewhere, .hideoperator, .hidecolumn {
        visibility: hidden;
    }
    
</style>
<script type="text/javascript">
function showTable()
{
 
       $('.hidetable').css("visibility","visible");
}
function showWhere()
{
 
       $('.hidewhere').css("visibility","visible");
}
function showOperator()
{
 
       $('.hideoperator').css("visibility","visible");
}
function showColumn()
{
 
       $('.hidecolumn').css("visibility","visible");
}
</script>
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
        <div class="pad" style="width:700px;">
            <br />
            <label for="command"><span>COMMAND:</span>
            <select id="command"  onchange="showTable();">
                <option>None</option>
                <option>SELECT</option>
                <option>INSERT</option>
                <option>UPDATE</option>
                <option>DELETE</option>
            </select>
            </label>&nbsp;
               <label class="hidecolumn" for="column"><span></span>
            <select id="Select2" onchange="showColumn();">
                <option>None</option>
               <?php 
               $query_sql = "SELECT COLUMN_NAME
  FROM INFORMATION_SCHEMA.COLUMNS
 WHERE table_name = 'users'";
              $query_sql_result = $dbHost->prepare($query_sql);
              $query_sql_result->execute();
              $query_sql_result->setFetchMode(PDO::FETCH_BOTH);
              while($query_sql_row = $query_sql_result->fetch())
              { ?>
             <option><?php echo $query_sql_row["COLUMN_NAME"]; ?></option>
              <?php }
               ?>
            </select>
                 </label>
            <label class="hidetable" for="table"><span>FROM:</span>
            <select id="table" onchange="showColumn();">
                <option>None</option>
                <option>Article</option>
                <option>Category</option>
                <option>Comments</option>
                <option>Media</option>
                <option>Media_Link</option>
                <option>Parent</option>
                <option>Role</option>
                <option>User</option>
            </select>
                 </label>
             <label class="hidewhere" for="where"><span>WHERE:</span>
            <select id="where" onchange="showOperator();">
                <option>None</option>
               <?php 
               ?>
            </select>
                 </label>
                <label class="hideoperator" for="where"><span>OP:</span>
            <select id="Select1" onchange="showOperator();">
                <option>None</option>
                       <option>=</option>
                 <option>!=</option>
                    <option><</option>
                 <option>></option>
                <option><=</option>
                 <option>>=</option>
            </select>
                 </label>
  		    <textarea id="sqlquery" name="sqlquery" style="width: 600px; height:80px"> <?php if (isset($_REQUEST["sqlquery"]))
      { 
          echo $_REQUEST["sqlquery"];
               } ?></textarea>
            <br /><br />
            <input id="submit" type="submit" value="Submit Query" />
            <br /><br />
            <table id="sqlresult" name="sqlresult" style="height:350px; background-color:#cccccc;" >
                 <?php if (isset($_REQUEST["sqlquery"]))
      { 
                echo $display_string;
               } ?>
            </table>
        </div>
    </form>
 </div>

<?php include '../includes/footer-site.php' ?>