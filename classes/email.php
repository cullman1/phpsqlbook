class emailer
{
  const newline = "\r\n";
  private $server;
  private $port;
  private $mailServer;
  private $socket;

  public $username;
  public $password; 
  public $connectTimeout; 
  public $responseTimeout,
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
  
  private function FormatAddress(&$address)
  {
    if ($address[1] == "") return $address[0]; else return "\"{$address[1]}\" <{$address[0]}>";
  }
  
  private function FormatAddressList(&$addresslist)
  {
    $list = "";
    foreach ($addresslist as $address)
    {
      if ($list) $list .= ", ".self::newline."\t";
      $list .= $this->FormatAddress($address);
    }
    return $list;
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
    $this->from = array($address,$name);
  }
  
}

class simple_emailer extends emailer
{
    function __construct()
   {	
        $this->server = "mailserver.com";
        $this->port = 25;
        $this->mailServer = "mail.yourmaildomain"; 
    }

    function getSimpleEmailProperty() {
    
    }
}

class google_ emailer extends emailer
{
    function __construct()
   {	
        $this->server = "mailserver.com";
        $this->port = 25;
        $this->mailServer = "mail.yourmaildomain"; 
    }

	function getGoogleEmailProperty() {
    }
}


?>