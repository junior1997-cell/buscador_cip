<?php

  ob_start();

  // if (strlen(session_id()) < 1) {

  //   session_start(); //Validamos si existe o no la sesión
  // }

  // if (!isset($_SESSION["nombre"])) {
  //   $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
  //   echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
  // } else {

    //Validamos el acceso solo al usuario logueado y autorizado.
    // if ($_SESSION['recurso'] == 1) {
    if (true) {

      require_once "../modelos/Test.php";

      $trabajador = new Test();

      date_default_timezone_set('America/Lima');  $date_now = date("d-m-Y h.i.s A");

      $imagen_error = "this.src='../dist/svg/user_default.svg'";
      $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
      
      $idtrabajador	  	= isset($_POST["idtrabajador"])? limpiarCadena($_POST["idtrabajador"]):"";
      $nombre 		      = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
      $tipo_documento 	= isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
      $num_documento  	= isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";

      switch ($_GET["op"]) {

        case 'mostrar_data':

          $rspta=$trabajador->mostrar_data();

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
  // }


  ob_end_flush();

?>
