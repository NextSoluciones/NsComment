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
      $response = $fb->get('/me?fields=id,name,accounts');
      $userNode = $response->getGraphUser();
      $fanpage=$response->getGraphNode();
      $fanp[]=$fanpage->asArray();
      $fanpL2=$fanp[0]["accounts"];
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    echo 'Haz iniciado sesión correctamente como ' . $userNode->getName()."<br/>";

    $_SESSION['logueado'] =true;
    $id=$userNode->getId();
?>
<section>
  <article class="busqueda">
    <form class="formulario" action="procesaPost.php" method="post">
      <h2>Post Propio</h2>
      <span>Selecciona p&aacute;gina asociada: </span><select class="fanpage-select" name="fanpage">
        <?php
          foreach ($fanpL2 as $fp) {
            $id_fp=$fp['id'];
            $nombre=$fp['name'];
            echo "<option value='$id_fp'>$nombre</option>";
          }
        ?>
        <option value='<?=$id?>'><?=$userNode->getName()?></option>
      </select>
      <span>Post a procesar (id.): </span><input type="text" name="id_post" value="" placeholder="p.e. <?=$id?>"/>
      <input type="submit" value="Procesar">
    </form>
    <form class="formulario" action="procesaPost.php" method="post">
      <h2>Post P&uacute;blico</h2>
      <span>Ingrese id. de fanpage: </span><input type="text" name="id_fp" value="" placeholder="p.e. <?=$id_fp?>"/>
      <span>Post a procesar (id.): </span><input type="text" name="id_post" value="" placeholder="p.e. <?=$id?>"/>
      <input type="submit" value="Procesar">
    </form>
  </article>
</section>
<footer><ul id="pie">
  <li>Desarrollado por <a href="https://www.nslatino.com">Next Soluciones Inform&aacute;ticas</a> - Todos los derechos reservdos</li>
</ul></footer>
</body>
</html>
