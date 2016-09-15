<?php 
class User {
    public $fullName;
    private $emailAddress;
    private $authenticated;
    private $role;

    function __construct($fullName, $emailAddress, $authenticated) {
        $this->fullName = $fullName;
        $this->emailAddress = $emailAddress;
        $this->authenticated = $authenticated;
        $this->role = "1";
    }
    
    public function getFullName() {
        return $this->fullName;
    }
    
    public function getEmailAddress() {
        return $this->emailAddress;
    }
    
    public function getAuthenticated() {
        return $this->authenticated;
    }
  

    public function setFullName($name) {
        $this->fullName = $name;
    }
    
    public function setEmailAddress($email) {
        $this->emailAddress = $email;
    }
    
    public function setAuthenticated($authenticate) {
        $this->authenticated = $authenticate;
    }
}
           session_start();
           
            function create_session() {
                $_SESSION['language'] = "en-gb";
                $_SESSION['timezone'] = "GMT";
                $_SESSION['currency'] = "Sterling";
                $locale = array('timezone' => 'EST', 'language' => 'EN-US', 'currency' => 'USD');
			    $_SESSION['locale'] = $locale;
                $results = new stdClass();   
                $results->name = "Chris"; 
                $_SESSION['name'] = $results;

                $user = new User("","jon@deciphered.com","1","1");   

                $_SESSION['user'] = $user;
            } 

            if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST["submit"]=="login")) {   
                create_session();
            } 
            if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST["submit"]=="logout")) {
                if (isset($_SESSION['language'])) {
                    session_unset();
                    setcookie(session_name(),'', time()-3600, '/');
                } 
            } 
            if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST["submit"]=="remove")) {
                unset($_SESSION['currency']); 	
            } 

?>
<form method="post" action="sessions_new.php">
  <h1>Please press:</h1>
	<?php if (isset($_SESSION['language'])) { 
              echo "SESSIONS <br/>Language " . $_SESSION['language'] . "<br/>Timezone " . $_SESSION['timezone'] . "<br/>Currency " . $_SESSION['currency']; 
 echo "<br/><br/>Timezone " . $_SESSION['locale']['timezone']; 	
if (isset($_SESSION['locale']['timezone'])) { 
echo "<br/><br/>Timezone " . $_SESSION['locale']['timezone'];
} 	
if (isset($_SESSION['user']->fullName)) { 
 echo "<br/><br/>User " . $_SESSION['user']->fullName; 
} ?>		
<br><button name="submit" value="logout" type="submit">Logout</button>   
    <br><button name="submit" value="remove" type="submit">Remove currency</button>  
			<?php } else { ?>
  <br><button name="submit" value="login" type="submit">Login</button>    
 <?php } ?>
</form>
