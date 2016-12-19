<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>nscomment</title>
  </head>
  <body>
    <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1830686757172000',
      xfbml      : true,
      version    : 'v2.8'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>
<?php /*
session_start();
include "bin/config.php";
require_once __DIR__ . '/vendor/autoload.php';
$accesso= new Config();

$fb = new Facebook\Facebook([
  'app_id' => $accesso->get_id(),
  'app_secret' => $accesso->get_secret(),
  'default_graph_version' => $accesso->get_version()
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes', 'manage_pages']; // optional
$loginUrl = $helper->getLoginUrl('https://www.nslatino.com/nscomment/login/procesaLogin.php', $permissions);
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';*/
?>
</body>
</html>
