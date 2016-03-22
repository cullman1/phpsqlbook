<?php
$timeout = 30; // your own timeout value
$connection_type = 'tcp'; // may be ssl, sslv2, sslv3 or tls
$host = 'localhost';
$port = 25;

$fp = stream_socket_client("{$connection_type}://{$host}:{$port}", $errno, $errstr, $timeout);

if (!$fp) {
    echo "$errstr ($errno)";
}

else
{
  echo "works";   
}
?>