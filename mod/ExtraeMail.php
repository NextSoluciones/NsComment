<?php
class ExtraeMail{
  var $tld1;
  var $tld2;
  var $bool_tld2;
  var $correos=[];
  //var $debug="Iniciando debug...<br/>";
  public function getCorreos(){
    return $this->correos;
  }
  // public function debug(){
  //   return $this->debug;
  // }
  public function Extraer($cad){
    $procesa1=explode(" ",$cad);
    $n1=count($procesa1);
    $indice=[];

    for ($i=0; $i < $n1; $i++) {
      $pos=strpos($procesa1[$i],'@');
      if (!($pos==false)) {
        $indice[]=$i;
      }
    }

    foreach ($indice as $caso) {
      $subcadena=$procesa1[$caso];
      $sub=explode("@",$subcadena);
      $host=explode(".",$sub[1]);
      if (strlen($host[2])<3) {
          $this->tld2=$host[2];
          if (ctype_alpha($this->tld2)) {
            $this->bool_tld2=true;
          }
          else {
            $this->bool_tld2=false;
          }
      }
      else {
          $this->tld2=substr($host[2],0,3);
          if (ctype_alpha($this->tld2)) {
            $this->bool_tld2=false;
          }
          else {
            $this->tld2=substr($this->tld2,0,2);
            if (ctype_alpha($this->tld2)) {
              $this->bool_tld2=true;
            }
            else {
              $this->bool_tld2=false;
            }
          }
      }
      $cadena_2=$host[1];
      $n2=strlen($cadena_2);
      for ($i=0; $i < $n2; $i++) {
        $temp=substr($cadena_2,0,($i+1));
        if (ctype_alpha($temp)) {
          $this->tld1=$temp;
        }
        else {
          $this->bool_tld2=false;
        }
      }//punto de control - ok

      $usuario;
      $iterator=1;
      $start=-1;
      $user=$sub[0];
      while ($iterator > 0) {
        $temp=substr($user,$start);
        $temp2=$temp."@dominio.tld";
        $start--;
        if (filter_var($temp2, FILTER_VALIDATE_EMAIL)) {
          $usuario=$temp;
          $iterator++;
        }
        $iterator--;
      }
      /*
      $correoFinal=$usuario."@".$host[0].".".$this->tld1;
      if ($this->bool_tld2) {
        $correoFinal.=".".$this->tld2;
      }
      if (filter_var($correoFinal, FILTER_VALIDATE_EMAIL)) {
        $this->correos[]=$correoFinal;
      }
      */
    }
  }
}
?>
