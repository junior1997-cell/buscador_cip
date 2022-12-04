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

      require_once "../modelos/Datos_hijos.php";

      $datos_hijos = new Datos_hijos(); 

      date_default_timezone_set('America/Lima');  $date_now = date("d-m-Y h.i.s A");
      
      $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
      
      //obtenemos los datos de la vista datos_hijos.php
      $idhijos	  	    = isset($_POST["idhijos"])? limpiarCadena($_POST["idhijos"]):"";
      $idcolegiado	  	= isset($_POST["idcolegiado"])? limpiarCadena($_POST["idcolegiado"]):"";
      $num_documento	  = isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
      $nombre	  	      = isset($_POST["nombre_h_"])? limpiarCadena($_POST["nombre_h_"]):"";
      $apellido	       	= isset($_POST["apellido_h_"])? limpiarCadena($_POST["apellido_h_"]):"";
      $nacimiento	    	= isset($_POST["nacimiento"])? limpiarCadena($_POST["nacimiento"]):"";
      $sexo	  	        = isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";

      //obtenemos el valor de la variable accion
      // $idhijos, $idcolegiado, $num_documento, $nombre, $apellido, $nacimiento, $sexo

      switch ($_GET["op"]) {

        case 'guardaryeditar':

          if (empty($idhijos)){
            
            $rspta=$datos_hijos->insertar($idcolegiado, $num_documento, $nombre, $apellido, format_a_m_d($nacimiento),$sexo);
            
            echo json_encode($rspta, true);
  
          }else {
            // editamos un trabajador existente
            $rspta=$datos_hijos->editar($idhijos, $idcolegiado, $num_documento, $nombre, $apellido,format_a_m_d($nacimiento), $sexo);
            
            echo json_encode($rspta, true);
          }            

        break;

        case 'mostrar':

          $rspta=$datos_hijos->mostrar($idhijos);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);

        break;
        case 'desactivar':

          $rspta=$datos_hijos->desactivar($idhijos);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);

        break;
        case 'activar':

          $rspta=$datos_hijos->activar($idhijos);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);

        break;

        case 'tbla_principal':          

          $rspta=$datos_hijos->tbla_principal();
          
          //Vamos a declarar un array
          $data= Array(); $cont=1;

          if ($rspta['status'] == true) {

            foreach ($rspta['data'] as $key => $value) { 
          
              $data[]=array(
                "0"=>$cont++,
                "1"=>($value['estado'])?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$value['idhijos'].')" data-toggle="tooltip" data-original-title="Editar"><i class="fas fa-pencil-alt"></i></button>'.
                  ' <button class="btn btn-danger btn-sm" onclick="desactivar('.$value['idhijos'].', \''.encodeCadenaHtml($value['nombres']).'\', \''.encodeCadenaHtml($value['apellidos']).'\')" data-toggle="tooltip" data-original-title="Desactivar"><i class="fa-solid fa-trash-can"></i></button>':
                  '<button class="btn btn-warning btn-sm" onclick="mostrar('.$value['idhijos'].')" data-toggle="tooltip" data-original-title="Editar"><i class="fas fa-pencil-alt"></i></button>'.
                  ' <button class="btn btn-success btn-sm" onclick="activar('.$value['idhijos'].', \''.encodeCadenaHtml($value['nombres']).'\', \''.encodeCadenaHtml($value['apellidos']).'\')" data-toggle="tooltip" data-original-title="Editar"><i class="fa fa-check"></i></button>',
                "2"=> $value['nombres'].' '.$value['apellidos'],
                "3"=> $value['dni'],
                "4"=> $value['fecha_nacimiento'],
                "5"=> $value['sexo'],
                "6"=>(($value['estado'])?'<span class="text-center badge badge-success">Activado</span>': '<span class="text-center badge badge-danger">Desactivado</span>').$toltip,

              );
            }
            $results = array(
              "sEcho"=>1, //Información para el datatables
              "iTotalRecords"=>count($data), //enviamos el total registros al datatable
              "iTotalDisplayRecords"=>1, //enviamos el total registros a visualizar
              "data"=>$data);
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
