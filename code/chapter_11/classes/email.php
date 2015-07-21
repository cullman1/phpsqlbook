<?php class Emailer {
  const newline = "\r\n";
  public $server,$port,$mailServer,$socket,$user,$password;
  public $connectTimeout,$responseTimeout,$headers;
  public $from,$to,$subject,$message,$contentType;

  function __construct() {
    $this->server = "94.76.218.242";
    $this->port = 8889; 
    $this->mailServer = "eastcornwallharriers.com"; 
    $this->connectTimeout = 60;
    $this->responseTimeout = 8;
    $this->from = array();
    $this->to = array();
    $this->headers = array();
    $this->headers['MIME-Version'] = "1.0";
    $this->headers['Content-type'] = "text/html";
  }
  function SentTo($address,$name = "") {
     $this->to = array($address,$name);
  }
  function SentFrom($address) {
    $this->from = $address;
  }  
  private function SendCMD($CMD) {
    fputs($this->skt, $CMD . self::newline);
    return $this->GetResponse();
  }
  private function GetResponse() {
    stream_set_timeout($this->skt, $this->responseTimeout);
    $response = '';
    while (($line = fgets($this->skt, 515)) != false) {
      $response .= trim($line) . "\n";
      if (substr($line,3,1)==' ') break;
    }
    return trim($response);
  }
  function Send() {
    $newLine = self::newline;
    $this->skt = @fsockopen($this->server, $this->port, $errno, $errstr, $this->connectTimeout);
    if (empty($this->skt)) {
        return "ERROR: ".$errstr;
    }    
    $this->GetResponse();
    $this->SendCMD("EHLO {$this->mailServer}");
    $this->SendCMD("AUTH LOGIN");
    $this->SendCMD(base64_encode($this->user));
    $this->SendCMD(base64_encode($this->password));
    $this->SendCMD("MAIL FROM:<{$this->from}>");
    foreach ($this->to as $addr) {
      $this->SendCMD("RCPT TO:<{$addr}>");
    }
    $this->SendCMD("DATA");
    if (!empty($this->contentType)) {
        $this->headers['Content-type'] = $this->contentType;
    }      
    $this->headers['From'] = $this->from;
    $this->headers['To'] = $this->to[0];   
    $this->headers['Subject'] = $this->subject;
    $this->headers['Date'] = date('r');
    $headers='';
    foreach ($this->headers as $key => $val) {
        $headers .= $key . ': ' . $val . self::newline;
    }
    $this->SendCMD("{$headers}{$newLine}{$this->message}{$newLine}.");
    $this->SendCMD("QUIT");
    fclose($this->skt);
    return "true";
  }
} ?>