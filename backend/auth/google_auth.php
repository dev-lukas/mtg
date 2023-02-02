<?php
require_once(__DIR__.'/../../vendor/autoload.php');
require_once(__DIR__.'/../mysql_bridge.php');

//Start or resume a session
session_start();
$redirectUri = 'http://localhost/mtg/index.php';
  
// Create client request to access Google API 
$client = new Google\Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
 
// Authenticate code from Google OAuth Flow 
if (isset($_GET['code']) && !isset($_SESSION['id'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
    
    // Get mail
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    // Authenticate if mail is under authorized users
    $userdata = getUserData();
    foreach ($userdata as $user) {
        if(password_verify($email, $user[2])) {
            //Everything set, lets set some userdata
            $_SESSION['id'] = $user[0];
            $_SESSION['name'] = $user[1];
            $_SESSION['points'] = $user[3];
        }
    }
} else {
    echo '<span class="not-authorized"></span>';
}
?>