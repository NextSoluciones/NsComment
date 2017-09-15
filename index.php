<?php if(!session_id()) {session_start();}
include "bin/config.php";
    require_once __DIR__ . '/vendor/autoload.php';
    $accesso= new Config();

    $fb = new Facebook\Facebook([
      'app_id' => $accesso->get_id(),
      'app_secret' => $accesso->get_secret(),
      'default_graph_version' => $accesso->get_version()
    ]);

    if (isset($_SESSION['logueado'])) {
       if ($_SESSION['logueado']==true){
        header('Location: https://www.nslatino.com/nscomment/mod/me.php');
      }
    }

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['user_photos', 'user_videos', 'user_friends', 'user_status', 'user_tagged_places', 'user_posts', 'email', 'manage_pages', 'read_custom_friendlists', 'public_profile', 'basic_info']; // optional
    $loginUrl = $helper->getLoginUrl('https://www.nslatino.com/nscomment/login/procesaLogin.php', $permissions);
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="ANSI">
    <title>nscomment</title>
    <link rel="stylesheet" href="./index.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:700" rel="stylesheet">
  </head>
  <body>
    <h1>Gestion de Comentarios</h1>
    <?php   
    
    echo '<a href="' . $loginUrl . '"><img id="fb-login" src="assets/fb_login.png" alt="Iniciar Sesion con Facebook" /></a>';
    ?>
    <footer><ul id="pie">
      <li>Desarrollado por <a href="https://www.nslatino.com">Next Soluciones Inform&aacute;ticas</a> - Todos los derechos reservdos</li>
    </ul></footer>
</body>
</html>
