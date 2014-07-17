<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for inserting data. */
$select_category_sql = "select distinct category_template FROM category";
$select_category_result = $dbHost->prepare($select_category_sql);
$select_category_result->execute();
$select_category_result->setFetchMode(PDO::FETCH_ASSOC);

if (isset($_REQUEST["Submitted"]))
{
    /* Query SQL Server for inserting a new category. */
    $insert_category_sql = "INSERT INTO category (category_name, category_template) VALUES ('".$_REQUEST['CategoryName']."', '".$_REQUEST['CategoryParent']."')";
    $insert_category_result = $dbHost->prepare($insert_category_sql);
    $insert_category_result->execute();
    if($insert_category_result->errorCode()!=0) {  die("Insert Category Query failed"); }
    else
    {
        /* Redirect to original page */
        header('Location:../admin/categories.php');
    }   
}
include '../includes/header.php' ?>
  <div id="body">
    <form id="form1" method="post" action="new-category.php">
      <div id="middlewide">
        <div id="leftcol">
          <h2>Add New Category</h2><br />
          <table>
            <tr>
				   <td><span class="fieldheading">Category Name:</span></td>
				   <td><input id="CategoryName" name="CategoryName" type="text" /></td> 
			</tr>
            <tr>
                <td> </td><td>&nbsp; </td>
            </tr>
            <tr>
              <td><span class="fieldheading">Category Template:</span></td>
              <td>
                <select id="CategoryParent" name="CategoryParent">
                    <?php while($select_category_row = $select_category_result->fetch()) { ?>
                    <option><?php  echo $select_category_row['category_template']; ?></option>
                    <?php } ?> 
                </select>
              </td> 
            </tr>
            <tr>
                <td> </td><td>&nbsp; </td>
            </tr>
            <tr>
				<td></td>
                <td>
                    <input id="SaveButton" type="submit" name="submit" Value="Submit"  />
                    <input id="Submitted" name="Submitted" type="hidden" value="true" />
			    </td>
			</tr> 
          </table>
          <br />
          <br />
      </div>
      <br />
      <a id="Return2" href="../admin/categories.php">Return to Main Page</a>
      </div>
    </form>
  <!--end content --> 
  </div>
<div class="clear"></div>
<?php include '../includes/footer-editor.php' ?>