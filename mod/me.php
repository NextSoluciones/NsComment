<?php
if(!session_id()) {
session_start();
}
include "./../bin/config.php";
require_once __DIR__ . './../vendor/autoload.php';

$accesso= new Config();

$fb = new Facebook\Facebook([
  'app_id' => $accesso->get_id(),
  'app_secret' => $accesso->get_secret(),
  'default_graph_version' => $accesso->get_version()
]);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sesion iniciada</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../index.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:700" rel="stylesheet">

  </head>
  <body>
    <div class="container">
    <div class="page-header">
    <h1>Obtener emails de comentarios <small>en post de Facebook</small></h1>
    </div>
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

    echo 'Haz iniciado sesión correctamente como <strong>' . $userNode->getName()."</strong><br/>";

    $_SESSION['logueado'] =true;
    $id=$userNode->getId();
?>
<section>
  <article class="busqueda">
    <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
          Post Propio</a>
        </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">
    <form class="formulario" action="procesaPost.php" method="post">
      <label for="sel1">Selecciona p&aacute;gina asociada: </label><select id="sel1" class="fanpage-select form-control" name="fanpage">
        <?php
          foreach ($fanpL2 as $fp) {
            $id_fp=$fp['id'];
            $nombre=$fp['name'];
            echo "<option value='$id_fp'>$nombre</option>";
          }
        ?>
        <option value='<?=$id?>'><?=$userNode->getName()?></option>
      </select>
      <label for="usr">Post a procesar (id.): </label><input type="text" id="usr" class="form-control" name="id_post" value="" placeholder="p.e. <?=$id?>"/>
      <input type="submit" class="btn btn-primary btn-block" value="Procesar">
    </form>
</div>
</div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        Post P&uacute;blico</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">
    <form class="formulario" action="procesaPost.php" method="post">
      <label for="url_fp">Ingrese url de fanpage: </label> <input type="text" id="url_fp" class="form-control" name="url_fp" value="" placeholder="p.e. https://www.facebook.com/EnappPeru"/>
      <label for="id_fp">Post a procesar (id.): </label> <input type="text" id="id_fp" class="form-control" name="id_post_fp" value="" placeholder="p.e. <?=$id?>"/>
      <input type="submit" class="btn btn-primary btn-block" value="Procesar">
    </form>
  </div>
</div>
  </div>
</div>
  </article>
</section>
<footer><ul id="pie">
  <li>Desarrollado por <a href="https://www.nslatino.com">Next Soluciones Inform&aacute;ticas</a> - Todos los derechos reservdos</li>
</ul></footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</div>
</body>
</html>
