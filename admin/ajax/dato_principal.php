<?php

  ob_start();

  if (strlen(session_id()) < 1) {

    session_start(); //Validamos si existe o no la sesión
  }

  if (!isset($_SESSION["nombre"])) {
    $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
    echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
  } else {

    //Validamos el acceso solo al usuario logueado y autorizado.
    if ($_SESSION['colegiado'] == 1 || $_SESSION['admin'] == 1) {

      require_once "../modelos/DatoPrincipal.php";

      $dato_principal = new DatoPrincipal();

      date_default_timezone_set('America/Lima');  $date_now = date("d-m-Y h.i.s A");

      $imagen_error = "this.src='../dist/svg/user_default.svg'";
      $toltip       = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
 
      $usuario	  	= isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
      $password 	  = isset($_POST["password"])? limpiarCadena($_POST["password"]):"";
      $email 	      = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
      $celular  	  = isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
      $direccion		= isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";     

      switch ($_GET["op"]) {

        case 'guardar_y_editar_colegiado':
          
          
          // editamos un trabajador existente
          $rspta=$dato_principal->editar( $usuario, $password, $email, $celular, $direccion);
          
          echo json_encode($rspta, true);                     

        break;

        case 'mostrar':

          $rspta=$dato_principal->mostrar();
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);

        break;            

        default: 
          $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
        break;

      }

      //Fin de las validaciones de acceso
    } else {
      $retorno = ['status'=>'nopermiso', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
      echo json_encode($retorno);
    }
  }

  function calculaedad($fechanacimiento){
    $ano_diferencia = '-';
    if (empty($fechanacimiento) || $fechanacimiento=='0000-00-00') { } else{
      list($ano,$mes,$dia) = explode("-",$fechanacimiento);
      $ano_diferencia  = date("Y") - $ano;
      $mes_diferencia = date("m") - $mes;
      $dia_diferencia   = date("d") - $dia;
      if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    } 
    
    return $ano_diferencia;
  }

  ob_end_flush();

?>
