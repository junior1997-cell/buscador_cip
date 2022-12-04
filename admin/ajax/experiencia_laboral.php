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

      require_once "../modelos/ExperienciaLaboral.php";

      $experiencia_laboral = new ExperienciaLaboral();

      date_default_timezone_set('America/Lima');  $date_now = date("d-m-Y h.i.s A");

      $imagen_error = "this.src='../dist/svg/user_default.svg'";
      $toltip       = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
      
      // experiencia laboral 
      $idexperiencia_laboral= isset($_POST["idexperiencia_laboral"])? limpiarCadena($_POST["idexperiencia_laboral"]):"";
      $empresa_select2	  	= isset($_POST["empresa_select2"])? limpiarCadena($_POST["empresa_select2"]):"";
      $fecha_inicio 	      = isset($_POST["fecha_inicio"])? limpiarCadena($_POST["fecha_inicio"]):"";
      $fecha_fin 	          = isset($_POST["fecha_fin"])? limpiarCadena($_POST["fecha_fin"]):"";
      $trabajo_actual  	    = isset($_POST["trabajo_actual"])? limpiarCadena($_POST["trabajo_actual"]) :"";
      $cargo_laboral		    = isset($_POST["cargo_laboral"])? limpiarCadena($_POST["cargo_laboral"]) :"";
      $url_empresa		      = isset($_POST["url_empresa"])? limpiarCadena($_POST["url_empresa"]):"";   
      $bg_color_select2	  	= isset($_POST["bg_color_select2"])? limpiarCadena($_POST["bg_color_select2"]):"";    

      // empresa
      $idempresa	  	      = isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
      $num_documento_empresa= isset($_POST["num_documento_empresa"])? limpiarCadena($_POST["num_documento_empresa"]):"";
      $nombre_empresa 	    = isset($_POST["nombre_empresa"])? limpiarCadena($_POST["nombre_empresa"]):"";
      $direccion_empresa    = isset($_POST["direccion_empresa"])? limpiarCadena($_POST["direccion_empresa"]):"";
      $telefono_empresa		  = isset($_POST["telefono_empresa"])? limpiarCadena($_POST["telefono_empresa"]):"";  
      $correo_empresa		    = isset($_POST["correo_empresa"])? limpiarCadena($_POST["correo_empresa"]):"";       

      switch ($_GET["op"]) {

        case 'guardar_y_editar_experiencia_laboral':      

          $trabajo_actual = (empty($_POST["trabajo_actual"]) ? '0' : '1'  );  //echo $trabajo_actual; die;  

          if (!file_exists($_FILES['doc1']['tmp_name']) || !is_uploaded_file($_FILES['doc1']['tmp_name'])) {
            $certificado=$_POST["doc_old_1"]; $flat_cv1 = false;
          } else {
            $ext3 = explode(".", $_FILES["doc1"]["name"]); $flat_cv1 = true;            
            $certificado = $date_now .' '. rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext3);
            move_uploaded_file($_FILES["doc1"]["tmp_name"], "../dist/docs/experiencia_laboral/certificado/" .  $certificado);            
          }
          if ( empty($idexperiencia_laboral) ) {
            $rspta=$experiencia_laboral->crear_experiencia( $empresa_select2, $fecha_inicio, $fecha_fin, $trabajo_actual, $cargo_laboral, $url_empresa, $bg_color_select2, $certificado);          
            echo json_encode($rspta, true); 
          } else {

            if ($flat_cv1 == true) {
              $datos = $experiencia_laboral->mostrar_datos_experiencia($idexperiencia_laboral );
              $doc_ant = $datos['data']['certificado'];
              if (empty($doc_ant )) { unlink("../dist/docs/experiencia_laboral/certificado/" . $doc_ant); }
            }    

            $rspta=$experiencia_laboral->editar_experiencia( $idexperiencia_laboral, $empresa_select2, $fecha_inicio, $fecha_fin, $trabajo_actual, $cargo_laboral, $url_empresa, $bg_color_select2, $certificado);          
            echo json_encode($rspta, true); 
          }          
          
        break;

        case 'mostrar_datos_experiencia':
          $rspta=$experiencia_laboral->mostrar_datos_experiencia($idexperiencia_laboral);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);
        break;   

        case 'eliminar_experiencia':
          $rspta=$experiencia_laboral->eliminar_experiencia($idexperiencia_laboral);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);
        break;   

        case 'listar_datos_experiencia':
          $rspta=$experiencia_laboral->listar_datos_experiencia();
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);
        break;   
        
        // .....::::::::::::::::::::::::::::::::::::: E M P R E S A   L A B O R A L  :::::::::::::::::::::::::::::::::::::::..
        
        case 'guardar_y_editar_empresa':          
          
          if (empty($idempresa)) {
            $rspta=$experiencia_laboral->crear_empresa( $num_documento_empresa, $nombre_empresa, $direccion_empresa, $telefono_empresa, $correo_empresa);          
            echo json_encode($rspta, true); 
          } else {
            $rspta=$experiencia_laboral->editar_empresa( $idempresa, $num_documento_empresa, $nombre_empresa, $direccion_empresa, $telefono_empresa, $correo_empresa);          
            echo json_encode($rspta, true); 
          }          
          
        break;

        case 'activar':
          $rspta=$experiencia_laboral->activar($idempresa);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);
        break;  

        case 'desactivar':
          $rspta=$experiencia_laboral->desactivar($idempresa);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);
        break;  

        case 'mostrar_editar_empresa':
          $rspta=$experiencia_laboral->mostrar_editar_empresa($idempresa);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);
        break;  

        case 'tabla_empresa_laboral':
           
          $rspta = $experiencia_laboral->tabla_empresa_laboral();
          
          //Vamos a declarar un array
          $data = []; $cont = 1;

          if ($rspta['status'] == true) {
            while ($reg = $rspta['data']->fetch_object()) {
              $data[] = [
                "0" => $cont++,
                "1" => $reg->estado ? '<button class="btn btn-warning btn-sm" onclick="mostrar_editar_empresa(' . $reg->idempresa .')" data-toggle="tooltip" data-original-title="Editar"><i class="fas fa-pencil-alt"></i></button>' .
                  ' <button class="btn btn-danger btn-sm" onclick="desactivar_empresa(' . $reg->idempresa .', \''.encodeCadenaHtml($reg->razon_social).'\')" data-toggle="tooltip" data-original-title="Desactivar"><i class="fa-solid fa-trash-can"></i></button>'
                  : '<button class="btn btn-warning btn-sm" onclick="mostrar_editar_empresa(' . $reg->idempresa . ')"><i class="fa fa-pencil-alt"></i></button>' .
                  ' <button class="btn btn-success btn-sm" onclick="activar_empresa(' . $reg->idempresa .', \''.encodeCadenaHtml($reg->razon_social).'\')" data-toggle="tooltip" data-original-title="Activar"><i class="fa fa-check"></i></button>',
                "2" => $reg->razon_social,
                "3" => $reg->ruc,
                "4" => '<textarea cols="30" rows="1" class="textarea_datatable" readonly="">' . $reg->direccion . '</textarea>',
                "5" => $reg->celular,
                "6" => $reg->correo,
                "7" => ($reg->estado ? '<span class="text-center badge badge-success">Activado</span>' : '<span class="text-center badge badge-danger">Desactivado</span>').$toltip,
              ];
            }
            $results = [
              "sEcho" => 1, //Información para el datatables
              "iTotalRecords" => count($data), //enviamos el total registros al datatable
              "iTotalDisplayRecords" => 1, //enviamos el total registros a visualizar
              "data" => $data,
            ];
  
            echo json_encode($results, true);
          } else {
            echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data'];
          }         
          
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
