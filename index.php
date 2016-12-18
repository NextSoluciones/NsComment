<?php
session_start();
include "bin/config.php";
require_once __DIR__ . '/vendor/autoload.php';
$accesso= new Config();
$aid= $accesso->get_id();
$asec=$accesso->get_secret();
$aver=$accesso->get_version();
echo $aid;
echo $asec;
echo $aver;
/*$fb = new Facebook\Facebook([
  'app_id' => $aid,
  'app_secret' => $asec,
  'default_graph_version' => $aver
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('https://www.nslatino.com/nscomment/login/procesaLogin.php', $permissions);
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
*/









?>
