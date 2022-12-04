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
    if ($_SESSION['colegiado'] == 1) {

      require_once "../modelos/MiCv.php";

      $mi_cv = new MiCv();

      date_default_timezone_set('America/Lima');  $date_now = date("d-m-Y h.i.s A");
      $imagen_error = "this.src='../dist/svg/user_default.svg'";
      $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
      
      // $idtrabajador	  	= isset($_POST["idtrabajador"])? limpiarCadena($_POST["idtrabajador"]):"";

      switch ($_GET["op"]) {     

        case 'guardar_y_editar_cv':
          // cv documentado
          if (!file_exists($_FILES['doc1']['tmp_name']) || !is_uploaded_file($_FILES['doc1']['tmp_name'])) {
            $cv_documentado=$_POST["doc_old_1"]; $flat_cv1 = false;
          } else {
            $ext3 = explode(".", $_FILES["doc1"]["name"]); $flat_cv1 = true;            
            $cv_documentado = $date_now .' '. rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext3);
            move_uploaded_file($_FILES["doc1"]["tmp_name"], "../dist/docs/colegiado/cv/" .  $cv_documentado);            
          }          
            
          //cvs
          if ($flat_cv1 == true) {
            $datos_cv1 = $mi_cv->obtenercv( );
            $cv1_ant = $datos_cv1['data']['documento_cv'];
            if (empty($cv1_ant )) { unlink("../dist/docs/colegiado/cv/" . $cv1_ant); }
          }          

          // editamos un trabajador existente
          $rspta=$mi_cv->editar_cv( $cv_documentado );            
          echo json_encode($rspta, true);              

        break;        
        
        case 'verdatos':
          $rspta=$mi_cv->mostrar_cv( );
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

  ob_end_flush();

?>
