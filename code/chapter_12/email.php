<?php class emailer
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

  function Send()
  {
    $newLine = self::newline;
    //Connect to the host on the specified port
    $this->skt = fsockopen($this->Server, $this->Port, $errno, $errstr, $this->ConnectTimeout);
    if (empty($this->skt))
      return false;
    $this->GetResponse();
    
    //Say Hello to SMTP
    $this->SendCMD("EHLO {$this->MailServer}");
    
    //Request Auth Login
    $this->SendCMD("AUTH LOGIN");
    $this->SendCMD(base64_encode($this->Username));
    $this->SendCMD(base64_encode($this->Password));
    
    //Email From
    $this->Log['mailfrom'] = $this->SendCMD("MAIL FROM:<{$this->From[0]}>");
    
    //Email To
    $i = 1;
    foreach (array_merge($this->To,$this->Cc) as $addr)
      $this->Log['rcptto'.$i++] = $this->SendCMD("RCPT TO:<{$addr[0]}>");
    
    //The Email
    $this->Log['data1'] = $this->SendCMD("DATA");
    
    //Construct Headers
    if (!empty($this->ContentType))
      $this->Headers['Content-type'] = $this->ContentType;
    $this->Headers['From'] = $this->FmtAddr($this->From);
    $this->Headers['To'] = $this->FmtAddrList($this->To);
    if (!empty($this->Cc))
      $this->Headers['Cc'] = $this->FmtAddrList($this->Cc);
    $this->Headers['Subject'] = $this->Subject;
    $this->Headers['Date'] = date('r');
    $headers = '';
    foreach ($this->Headers as $key => $val)
      $headers .= $key . ': ' . $val . self::newline;
    $this->Log['data2'] = $this->SendCMD("{$headers}{$newLine}{$this->Message}{$newLine}.");
    
    // Say Bye to SMTP
    $this->Log['quit']  = $this->SendCMD("QUIT");
    fclose($this->skt);
    return substr($this->Log['data2'],0,3) == "250";
  }
  
}

class simple_emailer extends emailer
{
    function __construct()
   {	
        $this->Server = "94.76.218.242";
        $this->Port =  8889; // or use alternate port 8889
        $this->MailServer = "eastcornwallharriers.com"; //Must exist in Control pael
        $this->ConnectTimeout = 30;
        $this->ResponseTimeout = 8;
        $this->From = array();
        $this->To = array();
        $this->Cc = array();
        $this->Log = array();
        $this->Headers['MIME-Version'] = "1.0";
        $this->Headers['Content-type'] = "text/plain; charset=iso-8859-1";
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