<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1830686757172000',
  'app_secret' => '92b01f24e5f7de615bc22597e85e79f8',
  'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('https://www.nslatino.com/bin/procesaLogin.php', $permissions);
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';










?>
