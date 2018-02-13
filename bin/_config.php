<?php
class Config {
  var $app_id="";//identificacion de la aplicacion
  var $app_secret='';//Clave secreta de la aplicación
  var $default_graph_version="";//v9.9
  public function get_id(){
    return $this->app_id;
  }
  public function get_secret(){
    return $this->app_secret;
  }
  public function get_version(){
    return $this->default_graph_version;
  }
}
?>
