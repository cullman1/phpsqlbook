<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting category template. */
$select_categorytemplate_sql = "select distinct category_template FROM category";
$select_categorytemplate_result = $dbHost->query($select_categorytemplate_sql);
# setting the fetch mode
$select_categorytemplate_result->setFetchMode(PDO::FETCH_ASSOC);

$select_category_sql = "select category_id, category_name, category_template FROM category where category_id=".$_REQUEST["categoryid"];
$select_category_result = $dbHost->query($select_category_sql);
# setting the fetch mode
$select_category_result->setFetchMode(PDO::FETCH_ASSOC);
include '../includes/header.php' ?>
  <div id="body">
    <form id="form1" method="post" action="submit-category.php">
       <?php while($select_category_row = mysql_fetch_array($select_category_result)) { ?>
      <div id="middlewide">
        <div id="leftcol">
          <h2>Edit Category</h2><br />
          <table>
            <tr>
				 <td><span class="fieldheading">Category Name:</span></td>
				 <td><input id="CategoryName" name="CategoryName" type="text" value="<?php echo $select_category_row['category_name']; ?>" /></td> 
			</tr>
            <tr><td></td><td>&nbsp; </td></tr>
            <tr>
              <td><span class="fieldheading">Category Template:</span></td>
              <td>
                <select id="CategoryParent" name="CategoryParent">
                 <?php while($select_categorytemplate_row = mysql_fetch_array($select_categorytemplate_result)) { ?>
                <option <?php if( $select_category_row['category_template'] == $select_categorytemplate_row['category_template']) { echo "selected";} ?> ><?php  echo $select_categorytemplate_row['category_template']; ?></option>
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
          <input id="categoryid" name="categoryid" type="hidden" value="<?php echo $_REQUEST['categoryid']; ?>"/>
          <br />
          <br />
          <div id="Status" >
            <?php 
	           if(isset($_REQUEST['submitted']))
	           {
		          echo "<span class='red'>Category successfully edited</span>";
	           }  
	         ?>
         </div>
      </div>
      <br />
      <a id="Return2" href="../admin/categories.php">Return to Main Page</a>
      </div>
    </form>
    <?php } ?>
  <!--end content --> 
</div>
<div class="clear"></div>
<?php include '../includes/footer-editor.php' ?>