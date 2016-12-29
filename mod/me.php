<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sesion iniciada</title>
    <link rel="stylesheet" href="./../index.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:700" rel="stylesheet">
  </head>
  <body>
    <h1>Gestion de Comentarios</h1>

<?php
session_start();
include "./../bin/config.php";
require_once __DIR__ . './../vendor/autoload.php';

$accesso= new Config();

$fb = new Facebook\Facebook([
  'app_id' => $accesso->get_id(),
  'app_secret' => $accesso->get_secret(),
  'default_graph_version' => $accesso->get_version()
]);

?>
  <div class="logout"><a href="./../login/logout.php">Cerrar Sesi&oacute;n</a></div>
<?php
    // Sets the default fallback access token so we don't have to pass it to each request
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    try {
      $response = $fb->get('/me');
      $userNode = $response->getGraphUser();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    echo 'Haz iniciado sesión correctamente como ' . $userNode->getName();
    $_SESSION['logueado'] =true;
    $id=$userNode->getId();
?>
<section>
  <article class="busqueda">
    <form class="formulario" action="procesaPost.php" method="post">
      <span>Post a procesar (id.): </span><input type="text" name="id_post" value="" placeholder="p.e. <?=$id?>"/>
      <input type="hidden" name="id" value="<?=$id?>">
      <input type="submit" value="Procesar">
    </form>
  </article>
</section>
<footer><ul id="pie">
  <li><a href="./../legal.html">Avisos Legales y Pol&iacute;tica de Privacidad</a></li>
  <li><a href="./../terminos.html">T&eacute;rminos y Condiciones</a></li>
</ul></footer>
</body>
</html>
