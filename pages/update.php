<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting category template. */

    $select_user_sql = "select * FROM Users where user_id=1001";
    $select_user_result = $dbHost->prepare($select_user_sql);
    $select_user_result->execute();
    $select_user_result->setFetchMode(PDO::FETCH_ASSOC);

include '../includes/header.php' ?>
  <div id="body">
    <form id="form1" method="post" action="submit-user.php">
       <?php while($select_user_row = $select_user_result->fetch()) { ?>
      <div id="middlewide">
        <div id="leftcol">
          <h2>Edit User</h2><br />
          <table>
            <tr>
				 <td><span class="fieldheading">User Name:</span></td>
				 <td><input id="UserName" name="UserName" type="text" value="<?php echo $select_user_row['full_name']; ?>" /></td> 
			</tr>
            <tr><td></td><td>&nbsp; </td></tr>
               <tr>
				 <td><span class="fieldheading">User Email:</span></td>
				 <td><input id="UserEmail" name="UserEmail" type="text" value="<?php echo $select_user_row['email_address']; ?>" /></td> 
			</tr>
              <tr><td> </td><td>&nbsp; </td></tr>
            <tr>
		        <td></td>
				<td><input id="SaveButton" type="submit" name="submit" Value="Submit"  /></td>
			</tr> 
          </table>
          <input id="userid" name="userid" type="hidden" value="1001� />
          <br /><br />
          <div id="Status" >
            <?php 
	           if(isset($_REQUEST['submitted']))
	           {
		          echo "<span class='red'>User successfully edited</span>";
	           }  
	         ?>
         </div>
      </div>
      <a id="Return2" href="../admin/user.php">Return to Main Page</a>
      </div>

    </form>
    <?php } ?>
</div>
<div class="clear"></div>
<?php include '../includes/footer-editor.php' ?>
