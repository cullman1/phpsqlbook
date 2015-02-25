<?php class emailer
{
  const newline = "\r\n";
  public $server;
  public $port;
  public $mailServer;
  public $socket;

  public $username;
  public $password; 
  public $connectTimeout; 
  public $responseTimeout;
  public $headers;
  public $contentType;
  public $from; 
  public $to; 
  public $cc; 
  public $subject; 
  public $message;
  public $log;
  
  function __construct()
  {
    $this->connectTimeout = 30;
    $this->responseTimeout = 8;
    $this->from = array();
    $this->to = array();
    $this->cc = array();
    $this->log = array();
    $this->headers['MIME-Version'] = "1.0";
    $this->headers['Content-type'] = "text/plain; charset=iso-8859-1";
  }
  
  function SentTo($address,$name = "")
  {
    $this->to[] = array($address,$name);
  }
  
  function SentToCc($address,$name = "")
  {
    $this->cc[] = array($address,$name);
  }
  
  function SentFrom($address,$name = "")
  {
    $this->from[] = array($address,$name);
  }

  
  private function GetResponse()
  {
      stream_set_timeout($this->skt, $this->responseTimeout);
      $response = '';
      while (($line = fgets($this->skt, 515)) != false)
      {
          $response .= trim($line) . "\n";
          if (substr($line,3,1)==' ') break;
      }
      return trim($response);
  }
  
  private function SendCMD($CMD)
  {
      fputs($this->skt, $CMD . self::newline);
      return $this->GetResponse();
  }

  function Send()
  {
    $newLine = self::newline;
    
    //Connect to the host on the specified port
    $this->skt = @fsockopen($this->server, $this->port, $errno, $errstr, $this->connectTimeout);
    if (empty($this->skt)) {
        return false;
    }
    
    $this->GetResponse();
    
    //Say Hello to SMTP
    $this->SendCMD("EHLO {$this->mailServer}");
    
    //Request Auth Login
    $this->SendCMD("AUTH LOGIN");
    $this->SendCMD(base64_encode($this->username));
    $this->SendCMD(base64_encode($this->password));
    
    //Email From
     $this->SendCMD("MAIL FROM:<{$this->from[0]}>");
    
    //Email To
    $i = 1;
    if (!empty($this->cc)) {
        foreach (array_merge($this->to,$this->cc) as $addr) {
            $this->SendCMD("RCPT TO:<{$addr[0]}>");
        }
    }
    
    
    //The Email
    $this->SendCMD("DATA");
    
    //Construct Headers
    if (!empty($this->contentType)) {
        $this->Headers['Content-type'] = $this->contentType;
    }
    
    $this->Headers['From'] = $this->from[0];
    $this->Headers['To'] = $this->to[0];
    
    if (!empty($this->cc)) {
        $this->Headers['Cc'] = $this->cc[0];
    }
    
    $this->Headers['Subject'] = $this->subject;
    $this->Headers['Date'] = date('r');
    
    $headers = '';
    foreach ($this->Headers as $key => $val) {
        $headers .= $key . ': ' . $val . self::newline;
    }
    
    $this->SendCMD("{$headers}{$newLine}{$this->message}{$newLine}.");
    
    $this->SendCMD("QUIT");
    fclose($this->skt);
    return true;
  }
  
}

class simple_emailer extends emailer
{
    function __construct()
   {	
        $this->server = "94.76.218.242";
        $this->port =  8889; // or use alternate port 8889
        $this->mailServer = "eastcornwallharriers.com"; //Must exist in Control pael
       
    }

    
}

class google_emailer extends emailer
{
    function __construct()
   {	
       

        $smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'salondadasiegt@gmail.com',
        'password' => 'TVD!nner2'
    ));
    }


}


?>