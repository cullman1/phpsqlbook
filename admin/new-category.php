<?php 
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for inserting data. */
$tsql = "select distinct category_template FROM 387732_phpbook1.category";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

?>
<?php include '../includes/headereditor.php' ?>
  <div id="body">
    <form id="form1" method="post" action="addcategory.php">
      <div id="middlewide">
        <div id="leftcol">
          <h2>Add New Category</h2><br />
          <table>
            <tr>
				      <td><span class="fieldheading">Category Name:</span></td>
				      <td><input id="CategoryName" name="CategoryName" type="text" /></td> 
			       </tr>
            
            <tr><td> </td><td>&nbsp; </td></tr>
            <tr>
              <td><span class="fieldheading">Category Template:</span></td>

              <td>
                <select id="CategoryParent" name="CategoryParent">
                 <?php while($row = mysql_fetch_array($stmt)) { ?>
                <option><?php  echo $row['category_template']; ?></option>
                  <?php } ?> 
                  </select>
              </td> 
             </tr>
              <tr><td> </td><td>&nbsp; </td></tr>
            <tr>
				      <td></td>
				      <td><input id="SaveButton" type="submit" name="submit" Value="Submit"  /></td>
			       </tr> 
          </table>
          <br />
          <br />
          <div id="Status" >
            <?php 
	           if(isset($_GET['submitted']))
	           {
		          echo "<span class='red'>Category successfully created</span>";
	           }  
	         ?>
         </div>
      </div>
      <br />
      <a id="Return2" href="../index.html">Return to Main Page</a>
      </div>
    </form>
  <!--end content --> 
  </div>

  <div class="clear"></div>

<?php include '../includes/footereditor.php' ?>