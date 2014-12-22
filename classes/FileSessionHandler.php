<?php 

class session { 

    private $lifeTime; 
    private $dbHandle; 
    
    
    function open($savePath, $sessName) { 
        // Get session lifetime
        $serverName = "72.32.1.169";
        $userName = "387732_phpbook1";
        $password = "F8sk3j32j2fslsd0"; 
        $databaseName = "387732_phpbook1";
        
        $dbHost = new PDO("mysql:host=$serverName;dbname=$databaseName", $userName, 
                       $password);
        $dbHost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $this->lifeTime = get_cfg_var("session.gc_maxlifetime"); 
        $this->dbHandle = $dbHost; 
        return true; 
    } 
    
    function close() { 
        $this->gc(ini_get('session.gc_maxlifetime')); 
        return $this->dbHandle=null; 
    } 
    
    function read($sessID) { 
        
        $select_session_sql = "SELECT session_data AS d FROM sessions WHERE session_id = '$sessID' AND session_expiry > ".time(); 
        $select_session_result = $dbHost->prepare($select_session_sql);
        $select_session_result->execute();
        $select_session_result->setFetchMode(PDO::FETCH_ASSOC);	
        
        // return data 
        if($select_session_row = $select_session_result ->fetch()) {
            return $select_session_row['d']; 
        }
        return ""; 
    } 
    
    function write($sessID,$sessData) { 
        
        $newExp = time() + $this->lifeTime; 
        
        // Find existing session? 
        $select_session_sql = "SELECT COUNT(*)  FROM sessions  WHERE session_id = '$sessID'"; 
        $select_session_result = $dbHost->prepare($select_session_sql);
        $select_session_result->execute();
        $select_session_result->setFetchMode(PDO::FETCH_ASSOC);	
        $num_rows = $select_session_result->fetchColumn();
        
        // if yes, 
        if($num_rows>0) {
            
            // Update session 
            $update_session_sql ="UPDATE sessions SET session_expirt = '$newExp', session_data = '$sessData' WHERE session_id = '$sessID'";
            $update_session_result = $dbHost->prepare($select_session_sql);
            $update_session_result->execute();
            $update_session_result->setFetchMode(PDO::FETCH_ASSOC);	
            
            // if update happened, return true 
            if($update_session_result->rowCount()>0) { 
                return true; 
            } 
        }
        else { 
            
            // create a new row 
            $insert_session_sql = "INSERT INTO sessions (  session_id,  session_expiry, session_data) VALUES( '$sessID', '$newExp', '$sessData')"; 
            $insert_session_result = $dbHost->prepare($insert_session_sql);
            $insert_session_result->execute();
            $insert_session_result->setFetchMode(PDO::FETCH_ASSOC);	
            
            // if row was created, return true 
            if($insert_session_result->rowCount()>0) { 
                return true; 
            }
            else {
                return false; 
            }    
        }
    }
    
    function destroy($sessID) { 
        // delete session data 
        $delete_session_sql = "DELETE FROM sessions WHERE session_id = '$sessID'"; 
        $delete_session_result = $dbHost->prepare($delete_session_sql);
        $delete_session_result->execute();
        $delete_session_result->setFetchMode(PDO::FETCH_ASSOC);	
        
        // Return true, if completed
        if($delete_session_result->rowCount()>0) { 
            return true; 
        }
        else {
            return false; 
        }
    } 
    
    function gc($sessMaxLifeTime) { 
        // delete old sessions 
        $delete_session_sql = "DELETE FROM sessions WHERE session_expiry < ".time();
        $delete_session_result = $dbHost->prepare($delete_session_sql);
        $delete_session_result->execute();
        $delete_session_result->setFetchMode(PDO::FETCH_ASSOC);	
        
        // return affected rows 
 
        return $delete_session_result->rowCount(); 
    } 
} 

$session = new session(); 
session_set_save_handler(array(&$session,"open"), 
                         array(&$session,"close"), 
                         array(&$session,"read"), 
                         array(&$session,"write"), 
                         array(&$session,"destroy"), 
                         array(&$session,"gc"),
                         array(&$session,"dummy")); 
session_start(); 

?>