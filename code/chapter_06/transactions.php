<?php require_once('../includes/db_config.php');
try {
      $dbHost->beginTransaction();
      $ins_user_set = $dbHost->prepare("INSERT INTO users(full_name, email, date_joined, 
      user_image, active) VALUES ('Morton Walsh', 'morton@deciphered.com', 'morton.jpg', 
      '". date('Y-m-d H:i:s')."',  0");
      $ins_user_set->execute();  
      echo "<br/>User record inserted";
      $sel_user_sql = "SELECT LAST_INSERT_ID()";    
      $sel_user_set = $dbHost->prepare($sel_user_sql);
      $sel_user_set->execute(); 
      $last_id = $dbHost->lastInsertId();
      echo "<br/>User id retrieved";
      $ins_media_set = $dbHost->prepare("INSERT INTO media (name, file_type, url, user_id, 
      date_uploaded, media_title) VALUES ('morton.jpg','image/jpeg', :user_id,
      '../uploads/morton.jpg','". date('Y-m-d H:i:s')."', 'Picture of Morton')");
      $ins_media_set->bindParam(":userid",$last_id);
      $ins_media_set->execute();
      echo "<br/>Image added to media table";
      $dbHost->commit();
      echo "<br/>Transaction completed.";
} catch (Exception $e) {
      echo "<br/>Transaction failed, rolling back:" . $e->getMessage();       
      $dbHost->rollback();
} ?>
