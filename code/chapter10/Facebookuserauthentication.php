<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();

require_once( '../Facebook/FacebookSession.php' );
require_once( '../Facebook/FacebookRedirectLoginHelper.php' );
require_once( '../Facebook/FacebookRequest.php' );
require_once( '../Facebook/FacebookResponse.php' );
require_once( '../Facebook/FacebookSDKException.php' );
require_once( '../Facebook/FacebookRequestException.php' );
require_once( '../Facebook/FacebookAuthorizationException.php' );
require_once( '../Facebook/GraphObject.php' );
require_once( '../Facebook/Entities/AccessToken.php');
require_once( '../Facebook/HttpClients/FacebookHttpable.php');
require_once( '../Facebook/HttpClients/FacebookCurlHttpClient.php');
require_once( '../Facebook/HttpClients/FacebookCurl.php');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookCurl;

FacebookSession::setDefaultApplication( '838101672918431','8d77fe43aeac414752080cb768f01fff' );
$helper = new FacebookRedirectLoginHelper('http://test1.phpandmysqlbook.com/code/chapter10/Facebookuserauthentication.php', '838101672918431', '8d77fe43aeac414752080cb768f01fff');

try {
        $session = $helper->getSessionFromRedirect();
        if ($session) {
            // User logged in, get the AccessToken entity.
            $accessToken = $session->getAccessToken();
            echo "Logged in<br/>";
            $session = new FacebookSession($accessToken);
            $request = new FacebookRequest($session, 'GET', '/me');
            $response = $request->execute();
            $user_profile = $response->getGraphObject();
            echo "Name: " . $user_profile->getProperty('name') . "<br/>";
            echo "Birthday: " . $user_profile->getProperty('user_birthday') . "<br/>";
    }
    else
    {    
        $permissions = array('user_birthday');
        $loginUrl = $helper->getLoginUrl($permissions); 
        header("location:".$loginUrl);
        exit; 
    }
}
catch(FacebookSDKException $e) {
    $session = null;
    echo "Error ". $e;
} ?>
