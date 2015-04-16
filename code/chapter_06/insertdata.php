<?php require_once('../includes/db_config.php');
      if (!empty($_POST['pwd']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) ) {   
          $sel_user_set = $dbHost->prepare("SELECT * from user WHERE email = :email");
          $sel_user_set->bindParam(":email",$_POST['email']);
          $sel_user_set->execute();
          $sel_user_rows = $sel_user_set->fetchAll(PDO::FETCH_ASSOC);
          $num_rows = count($sel_user_rows);
          if($num_rows>0) {
              echo ("<div class='wholeform'>User already exists</div>");        
          }	
          else {
              $ins_user_set = $dbHost->prepare("INSERT INTO user (full_name, password, email, role_id, date_joined, active) VALUES (:name,:password,:email,:date,2,0)");
              $full_name = $_POST['firstName'] . " " . $_POST['lastName'];
              $day= date("Y-m-d H:i:s");
              $ins_user_set->bindParam(":name", $full_name);  
              $ins_user_set->bindParam(":password", $_POST['pwd']);  
              $ins_user_set->bindParam(":email", $_POST['email']);  
              $ins_user_set->bindParam(":date", $day);  
              $ins_user_set->execute();
              if($ins_user_set->errorCode()!=0) {  
                  echo ("<div class='wholeform'>User registration failed</div>");        
              }
              else {
                  echo ("<div class='wholeform'>User registration succeeded</div>");    
              }
          }
      } ?>