<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>nscomment</title>
    <link rel="stylesheet" href="./index.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:700" rel="stylesheet">
  </head>
  <body>
    <h1>Gesti&oacute;n de Comentarios</h1>
    <?php
    session_start();

    include "bin/config.php";
    require_once __DIR__ . '/vendor/autoload.php';
    $accesso= new Config();

    $fb = new Facebook\Facebook([
      'app_id' => $accesso->get_id(),
      'app_secret' => $accesso->get_secret(),
      'default_graph_version' => $accesso->get_version()
    ]);

    // if (isset($_SESSION['logueado'])) {
    //   if ($_SESSION['logueado']==true){
    //     header('Location: https://www.nslatino.com/nscomment/mod/me.php');
    //   }
    // }

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email', 'user_likes', 'manage_pages']; // optional
    $loginUrl = $helper->getLoginUrl('https://www.nslatino.com/nscomment/login/procesaLogin.php', $permissions);
    echo '<a href="' . $loginUrl . '">Inicia Sesi&oacute;n con Facebook!</a>';
    ?>
    <footer><ul id="pie">
      <li><a href="legal.html">Avisos Legales y Pol&iacute;tica de Privacidad</a></li>
      <li><a href="terminos.html">T&eacute;rminos y Condiciones</a></li>
    </ul></footer>
</body>
</html>
