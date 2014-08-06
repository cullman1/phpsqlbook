<?php include '../includes/header-site.php' ?>
<style>
    label { width: 200px; float: left; margin: 0 20px 0 0; }
    span { display: block; margin: 0 0 3px; font-size: 1.2em; font-weight: bold; }
    select { width: 150px; border: 1px solid #000; padding: 5px; }
    .hidewhere, .hideoperator, .hidecolumn, .hideinput {
        display: none;
    }  
</style>
<script type="text/javascript">
    function showInput(count) {
      
        alert(document.activeElement);
        $(document.activeElement).removeClass("hideinput");
        if ($(document.activeElement).is(':visible')) {
       
            $(document.activeElement).attr("class", "");
        } else {
            $(document.activeElement).attr("class", "");
        }
        $('#sqlquery').val($('#command').val());
    }
function showTable()
{
    $('.hidetable').css("display", "block");
    $('#sqlquery').val($('#command').val());
}
function showcolumn()
{
 colval = $('#column').val();

    if (colval == "NONE" || typeof colval == undefined) {
        colval = "*";
    }
    $('#sqlquery').val($('#command').val() + " " + colval + " FROM " + $('#table').val());
    $('.hidewhere').css("display", "block");
}
function showwhere() {
    colval = $('#column').val();

    if (colval == "NONE" || typeof colval == undefined) {
        colval = "*";
    }
    $('#sqlquery').val($('#command').val() + " " + colval + " FROM " + $('#table').val() + " WHERE ");
    $('.hideoperator').css("display", "block");
}
function showOperator()
{
    $('#sqlquery').val($('#command').val() + " " + $('#column').val() + " FROM " + $('#table').val() + " WHERE " + $('#where').val());
    $('.hideoperator').css("display", "block");
}
function showValue() {
    $('#sqlquery').val($('#command').val() + " " + $('#column').val() + " FROM " + $('#table').val() + " WHERE " + $('#where').val() + " " + $('#operator').val());
    $('.wherevalue').css("display", "block");
    $('.wherevalue').focus();
}

function completeValue() {
    finalval = "";
    if (isNaN($('#wherevalue').val()))
    {
        finalval = "'" + $('#wherevalue').val() + "'";
    }
    else
    {
        finalval = +$('#wherevalue').val();
    }
    $('#sqlquery').val($('#command').val() + " " + $('#column').val() + " FROM " + $('#table').val() + " WHERE " + $('#where').val() + " " + $('#operator').val() + " " + finalval);
    $('.wherevalue').css("display", "block");
}

function showRest()
{
 colval = $('#column').val();

    if (colval == "NONE" ||  colval == undefined) {
        colval = "*";
    }
 
    switch($('#command').val())
    {
        case "SELECT":
            $('#sqlquery').val($('#command').val() + " " + colval + " FROM " + $('#table').val());
     $('.hidecolumn').css("display", "none");
    $('.hidewhere').css("display", "block");
    $('.hideoperator').css("display", "none");
  $.get("func2.php", {
        func: "show_column",
        drop_var: $('#table').val()
    }, function (response) {
        setTimeout("finishAjax('placeholdercolumn', '" + escape(response) + "')", 400);
        setTimeout("finishAjax('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);

    });
            break;
        case "INSERT":
            $('#sqlquery').val($('#command').val() + " INTO " + $('#table').val() + " () VALUES ");
            $('.hidecolumn').css("display", "none");
            $('#whereheader').val("COLUMN:");
    $('.hidewhere').css("display", "block");
    $('.hideoperator').css("display", "none");
  $.get("func3.php", {
        func: "show_combo",
        drop_var: $('#table').val()
    }, function (response) {
        setTimeout("finishAjax('placeholdercolumn', '" + escape(response) + "')", 400);
        setTimeout("finishAjax('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);

    });
            break;
        case "UPDATE":
            $('#sqlquery').val($('#command').val() + " " + $('#table').val() + " SET ");
   $('.hidecolumn').css("display", "none");
    $('.hidewhere').css("display", "none");
    $('.hideoperator').css("display", "none");
            break;
        case "DELETE":
            $('#sqlquery').val($('#command').val() + " " + colval + " FROM " + $('#table').val());
   $('.hidecolumn').css("display", "none");
    $('.hidewhere').css("display", "block");
    $('.hideoperator').css("display", "none");
  $.get("func2.php", {
        func: "show_column",
        drop_var: $('#table').val()
    }, function (response) {
        setTimeout("finishAjax('placeholdercolumn', '" + escape(response) + "')", 400);
        setTimeout("finishAjax('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);

    });
            break;

    }
  

    return false;
}

function showFrom()
{
    $('#sqlquery').val("SELECT * FROM " + $('#table').val());
    $('.hidetable').css("display", "block");
    if ($('#sqlresult').html().trim()=="")
    {
        $('#hiddenpass').val($('#table').val());
        document.tableform.submit();
    }
    $.get("func2.php", {
        func: "show_column",
        drop_var: $('#table').val()
    },  function(response){
        setTimeout("finishAjax('placeholdercolumn', '" + escape(response) + "')", 400);
        setTimeout("finishAjax('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);
       
    });
    return false;
}

function finishAjax(id, response) {
    $('#'+id).html(unescape(response));
    $('#'+id).fadeIn();
}
 var check = '<?php if (isset(  $_POST['hiddenpass'])){ echo $_POST['hiddenpass'];} ?>';


</script>

<?php 
$display_string = "";
function isPostBack()
{
    return ($_SERVER['REQUEST_METHOD'] == 'POST');
}
if (!isPostBack())
{ ?>
    <style>
    .hidetable {
        display: none;
  }  
</style>
<?php  
}
if (isset($_REQUEST["sqlquery"]))
      {
          $display_string = "";
          try
          {
              $query_sql = $_REQUEST["sqlquery"];      
              $query_sql_result = $dbHost->prepare($query_sql);
              $query_sql_result->execute();
              $query_sql_result->setFetchMode(PDO::FETCH_BOTH);     
              $query_sql = strtolower($query_sql);
              $exploded = explode(" ", $query_sql);
              $count = count($exploded)-1;
              $remember = 0;
              for ($j=0; $j<=$count; $j++)
              {
                  if ($exploded[$j]=="from")
                  {
                      $remember = $j-1;
                      $table_name = $exploded[$j+1];
                  }
              }
              if ($exploded[$remember]=="*")
              {
                $columnname_sql = "DESCRIBE ". $table_name;
                $columnname_result = $dbHost->prepare($columnname_sql);
                $columnname_result->execute();
                $columnname_row = $columnname_result->fetchAll(PDO::FETCH_COLUMN);
                $colcount = $query_sql_result->columnCount();
                $columncount = count($columnname_row)-1;
                $display_string .= "<tr>";
                for ($i=0;$i<$columncount+1;$i++)
                {
                  $display_string .= "<td><b style='font-size:11pt'>".$columnname_row[$i] . "</b></td> ";
                }
                $display_string .= "</tr>";
              }
              else
              {
                  $colcount = 1;
                  if ($exploded[$remember]=="") { $display_string .= "<tr><td colspan=10>No rows returned.</td></tr>";}
                  else
                  {
                  $display_string .= "<tr><td><b style='font-size:11pt'>".$exploded[$remember] . "</b></td></tr>";
                  }
              }
              $count=0;
              while($row = $query_sql_result->fetch())
              {
                  $count++;
                  $display_string .= "<tr>";
                  for ($i=0;$i<$colcount;$i++)
                  {
                      $display_string .=  "<td style='font-size:11pt'>".$row[$i] . "</td>";
                  }      
                  $display_string .= "</tr>";
              }
              if ($count==0)
              {
                  $display_string .= "<tr><td colspan=10>No rows returned.</td></tr>";
              }
             
          }
          catch (PDOException $e)
          {
              $display_string = "<tr style='vertical-align:top; '><td><b style='font-size:11pt'>ERROR ".$e->getMessage()."</b></td></tr>";         
          }
      }
?>
 <div class="small_box">
    <div class="small_box_top">
        SQL Query
    </div>
    <form id="form1" method="post" action="sql-test.php" name="tableform">
        <input id="hiddenpass" name="hiddenpass" type="hidden" />
        <div class="pad" style="width:790px;">
            <br />
            <label for="command" class="hidetable"><span>COMMAND:</span>
            <select id="command"  onchange="showRest();" style="width:200px">
                <option>None</option>
                <option>SELECT</option>
                <option>INSERT</option>
                <option>UPDATE</option>
                <option>DELETE</option>
            </select>
            </label>&nbsp;
            <label class="hidecolumn" for="column"><span>COLUMN:</span>
                <span id="placeholdercolumn"></span>
            </label>
            <label  for="table"><span>TABLE:</span>
            <select id="table" name="table" onchange="showFrom();" style="width:200px">
                <option value="None">None</option>
                <option value="article">article</option>
                <option value="category">category</option>
                <option value="comments">comments</option>
                <option value="media">media</option>
                <option value="media_link">media_link</option>
                <option value="parent">parent</option>
                <option value="role">role</option>
                <option value="user">user</option>
            </select>
                 </label>
            <label class="hidewhere" for="where"><span id="whereheader">WHERE:</span>
                  <span id="placeholderwhere"></span>
            </label>
            <label class="hideoperator" for="where"><span>OP:</span>
            <select id="operator" onchange="showValue();" style="width:200px">
                <option>None</option>
                <option>=</option>
                <option>!=</option>
                <option><</option>
                <option>></option>
                <option><=</option>
                <option>>=</option>
                <option>LIKE</option>
            </select>
            </label>
            <label class="hideoperator" for="where"><span>VALUE:</span>
            <input id="wherevalue" type="text" name="wherevalue" /><input id="addvalue" type="button" value="Add value to SQL" onclick="completeValue();" />
            </label>
  		    <textarea id="sqlquery" name="sqlquery" style="width: 790px; height:120px"> <?php if (isset($_REQUEST["sqlquery"]))
                { 
                    echo $_REQUEST["sqlquery"];
               } ?></textarea>
            <br /><br />
       <input id="gogogo" type="submit" name="submit_button" value="Submit Query" />
            <br /><br />
            <table id="sqlresult" name="sqlresult" style="height:350px; background-color:#cccccc;" >
                 <?php if (isset($_REQUEST["sqlquery"]))
                { 
                echo $display_string;
               } ?>
            </table>
        </div>
    </form>
     <script type="text/javascript">

if (check != "")
{

      var selectset = document.getElementById("table");
    selectset.value = check;
}
     </script>
 </div>
<?php include '../includes/footer-site.php' ?>