<?php
class ExtraeMail{
  var $tld1;
  var $tld2;
  var $bool_tld2;
  var $correos=[];
  var $debug="joder...<br/>";
  public function getCorreos(){
    $temp=$this->correos;
    $this->correos=[];
    return $temp;
  }
  public function debug(){
     return $this->debug;
  }
  public function Extraer($cad){
    $procesa1=explode(" ",$cad);
    $n1=count($procesa1);
    $indice=[];
    $preArrobaInd=[];
    for ($i=0; $i < $n1; $i++) {
      $pos=strpos($procesa1[$i],'@',0);
      if ($pos>=0) {
        $this->debug.="pos='".$pos."'<br/>";
        $indice[]=$i;
        $n=$i-1;
        $bandera=true;
        if ($pos==0) {
          $this->debug.="No hay nada antes del arroba<br/>";
          $cadEM=trim($procesa1[$n]);
          while ($bandera) {
            if (strlen($cadEM)>0) {
              $bandera=false;
              $preArrobaInd[]=$n;
            }
            else {
              $n--;
              if ($n<=0) {
                $bandera=false;
              }
            }
          }
        }
        else {
          $preArrobaInd[]=0;
        }
        // $cadxx=$procesa1[$i]."<br/>";
        // $this->debug.=$cadxx;
      }
    }

    foreach ($indice as $caso) {
      $subcadena=$procesa1[$caso];
      $sub=explode("@",$subcadena);
      $this->debug.="sub[0]='".$sub[0]."'<br/>";
      if (!(strlen($sub[0])>0)) { //ocurrirá cuando la cadena empieze en arroba
        $this->debug.="Se dio el caso de usuario nulo";
        $m=$preArrobaInd[$caso];
        $sub[0]=$procesa1[$m];
      }
      $host=explode(".",$sub[1]);
      if (isset($host[1])&&strlen($host[1])>2){
        $cadena_2=$host[1];
        $n2=strlen($cadena_2);
        for ($i=0; $i < $n2; $i++) {
          $temp=substr($cadena_2,0,($i+1));
          if (ctype_alpha($temp)) {
            $this->tld1=$temp;
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
          }
          else {
            $this->bool_tld2=false;
          }
        }
      }
      else {
        $this->tld1="com";
        $cadenaHost=$host[0];
        $iterator=1;
        $control=0;
        $startN=0;
        $long=0;
        $cadPre="user@";
        $cadPost=".com";
        while ($iterator > 0&& $control<100) {
            $control++;
            if ($startN==0){
              $temp=substr($cadenaHost,0);
            }
            else {
              $temp=substr($cadenaHost,0,$startN);
            }
            $long=strlen($temp);
            $temp2=$cadPre.$temp.$cadPost;
              if (filter_var($temp2, FILTER_VALIDATE_EMAIL)) {
                $this->debug.="Filtro Válido: '".$temp2."'<br/>";
                $host[0]=$temp;
                $iterator--;
                if ($long<=1) {
                  $iterator--;
                }
              }
              else {
                $this->debug.="Filtro No Válido: '".$temp2."'<br/>";
                if ($long>1) {
                  $iterator++;
                }
                else {
                  $iterator--;
                }
              }
              $iterator--;
              $startN--;
          }
      }

      //punto de control - ok

      $usuario="";
      $iterator=1;
      $start=0;
      $user=$sub[0];
      $control=0;
      $nuser=strlen($user);

      while ($iterator > 0&& $control<1500) {
          $control++;
          $temp=substr($user,$start);
          $temp2=$temp."@dominio.tld";
            if (filter_var($temp2, FILTER_VALIDATE_EMAIL)) {
              $usuario=$temp;

              $iterator--;
              if (($nuser+1)==abs($start)) {
                $iterator--;
              }
            }
            else {
              if (abs($start)<($nuser+1)) {
                $iterator++;
              }
              else {
                $iterator--;
              }
            }
            $iterator--;
            $start++;
        }

      $correoFinal=$usuario."@".$host[0].".".$this->tld1;
      $this->debug.=$correoFinal."<br/>";
      if ($this->bool_tld2) {
        $correoFinal.=".".$this->tld2;
      }

      if (filter_var($correoFinal, FILTER_VALIDATE_EMAIL)) {
        $this->correos[]=$correoFinal;
      }

    }
    //Final de la funcion Extraer
    $this->debug.="Punto de control A<br/>";
    ob_start();
    var_dump($preArrobaInd);
    $result = ob_get_clean();
    $this->debug.=$result;
    $this->debug.="<br/>Punto de control B<br/><br/>";
  }
}
?>
