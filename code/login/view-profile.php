<?php
require_once('../classes/registry.php');
require_once('../classes/configuration.php');
$registry = Registry::instance();
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$pdoString="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($pdoString, $db->getUserName(), $db->getPassword()); 
$pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
$registry->set('pdo', $pdo);
$dbHost =  $registry->get('pdo');

if (isset($_GET["profile"])) {
    $select_user_sql = 'Select * from user where user_id='.$_GET["profile"];
    $select_user_result = $dbHost->prepare($select_user_sql);
    $select_user_result->execute();
 
}
?>
  <div id="body">
       <?php while($select_user_row = $select_user_result->fetch()) { ?>
      <div id="middlewide">
        <div id="leftcol">
          <table>
            <tr>
				 <td><?php echo $select_user_row['user.full_name']; ?></td> 
			</tr>
               <tr>
                   	 <td><img src="../login/<?php echo $select_user_row['user.user_image']; ?>" /><br /><br />
                           </td> 
               
			</tr>
            <tr><td></td><td>&nbsp; </td></tr>
            <tr>
				 <td><span class="fieldheading">Email:</span></td>
				 <td><?php echo $select_user_row['user.email']; ?></td> 
			</tr>
              <tr>
				 <td><span class="fieldheading">Status:</span></td>
				 <td><?php echo $select_user_row['user.status']; ?></td> 
			</tr>
              <tr><td> </td><td>&nbsp; </td></tr>   
          </table>    
      </div>
      <br />
      <a id="Return2" href="../../article">Return to Main Site</a>
      </div>
    <?php } ?>
</div>
<div class="clear"></div>
