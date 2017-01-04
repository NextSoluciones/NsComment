<?php
class ExtraeMail{
  var $tld1;
  var $tld2;
  var $bool_tld2;
  var $correos=[];
  var $debug="Iniciando debug...<br/>";
  public function getCorreos(){
    return $this->correos;
  }
  public function debug(){
     return $this->debug;
  }
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

      $usuario="";
      $iterator=1;
      $start=-1;
      $user=$sub[0];
      $control=0;
      #Parece que entra en un bucle infinito. Poner un control que limite a 10
      $this->debug="<br/>iterator inicial: ".$iterator."<br/>";
      $this->debug="<br/>start inicial: ".$start."<br/>";
      $this->debug="<br/>user inicial: ".$user."<br/>";
      $this->debug="<br/>control inicial: ".$control."<br/>";
      while ($iterator > 0&& $control<10) {
        $this->debug="<br/>***********NUEVO CICLO************<br/>";
        $this->debug="<br/>iterator: ".$iterator."<br/>";
        $this->debug="<br/>start: ".$start."<br/>";
        $this->debug="<br/>user: ".$user."<br/>";
        $this->debug="<br/>control: ".$control."<br/>";
          $control++;
          $temp=substr($user,$start);
          $this->debug="<br/>temp: ".$temp."<br/>";
          $temp2=$temp."@dominio.tld";
          $this->debug="<br/>temp2: ".$temp2."<br/>";
          $start--;
            if (filter_var($temp2, FILTER_VALIDATE_EMAIL)) {
              $this->debug="<br/>******CONDICIONAL FILTRO*********<br/>";
              $usuario=$temp;
              $this->debug="<br/>user: ".$user."<br/>";
              $iterator++;
              $this->debug="<br/>iterator: ".$iterator."<br/>";
            }
          $iterator--;
          $this->debug="<br/>******DECRECE ITERATOR*********<br/>";
          $this->debug="<br/>iterator: ".$iterator."<br/>";
          $this->debug="<br/>******FIN CICLO*********<br/>";
        }
        $this->debug="<br/>******ESTADO FINAL WHILE*********<br/>";
        $this->debug="<br/>iterator final: ".$iterator."<br/>";
        $this->debug="<br/>start final: ".$start."<br/>";
        $this->debug="<br/>user final: ".$user."<br/>";
        $this->debug="<br/>control final: ".$control."<br/>";
      //punto de control --error

      $correoFinal=$usuario."@".$host[0].".".$this->tld1;
      if ($this->bool_tld2) {
        $correoFinal.=".".$this->tld2;
      }
      if (filter_var($correoFinal, FILTER_VALIDATE_EMAIL)) {
        $this->correos[]=$correoFinal;
      }

    }
  }
}
?>
