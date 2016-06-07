<?php 
           session_start();
            function create_session() {
                $_SESSION['language'] = "en-gb";
                $_SESSION['timezone'] = "GMT";
                $_SESSION['currency'] = "Sterling";
            } 

            if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST["submit"]=="login")) {   
                create_session();
            } else if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST["submit"]=="logout")) {
                if (isset($_SESSION['language'])) {
                    session_unset();
                    setcookie(session_name(),'', time()-3600, '/');
                } 
            } else if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST["submit"]=="remove")) {
                unset($_SESSION['currency']); 	
            }?>
<form method="post" action="sessions_new.php">
  <h1>Please press:</h1>
	<?php if (isset($_SESSION['language'])) { 
              echo "SESSIONS <br/>Language " . $_SESSION['language'] . "<br/>Timezone " . $_SESSION['timezone'] . "<br/>Currency " . $_SESSION['currency']; ?>
			<br><button name="submit" value="logout" type="submit">Logout</button>   
    <br><button name="submit" value="remove" type="submit">Remove currency</button>  
			<?php } else { ?>
  <br><button name="submit" value="login" type="submit">Login</button>    
 <?php } ?>
</form>
