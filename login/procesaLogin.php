<?php
session_start();
include "./../bin/config.php";
require_once __DIR__ . './../vendor/autoload.php';
$accesso= new Config();
var_dump($accesso);
/*$fb = new Facebook\Facebook([
  'app_id' => $accesso->get_id(),
  'app_secret' => $accesso->get_secret(),
  'default_graph_version' => $accesso->get_version()
]);

  $helper = $fb->getCanvasHelper();
  try {
    $accessToken = $helper->getAccessToken();
  }
  catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }


  if (isset($accessToken)) {
    // Logged in!
    $_SESSION['facebook_access_token'] = (string) $accessToken;


    // Logged in
    echo '<h3>Signed Request</h3>';
    var_dump($helper->getSignedRequest());

    echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());

    //echo "Login Exitoso. El access Token es ".$_SESSION['facebook_access_token'];
    //header('Location: https://www.nslatino.com/nscomment/mod/me.php');
    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
  }*/

?>
