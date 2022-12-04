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
    if ($_SESSION['recurso'] == 1) {

      require_once "../modelos/Conyuge.php";

      $conyuge = new Conyuge(); ///

      date_default_timezone_set('America/Lima');  $date_now = date("d-m-Y h.i.s A");

      $imagen_error = "this.src='../dist/svg/user_default.svg'";
      $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
      
      $idconyuge        = isset($_POST["idconyuge"])? limpiarCadena($_POST["idconyuge"]):"";
      $idcolegiado      = isset($_POST["idcolegiado"])? limpiarCadena($_POST["idcolegiado"]):"";
      $nombres          = isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
      $apellidos        = isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
      $fecha_nacimiento = isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]):"";
      $telefono1        = isset($_POST["telefono1"])? limpiarCadena($_POST["telefono1"]):"";
      $telefono2        = isset($_POST["telefono2"])? limpiarCadena($_POST["telefono2"]):"";
      $telefono3        = isset($_POST["telefono3"])? limpiarCadena($_POST["telefono3"]):"";
      $sexo             = isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";

      switch ($_GET["op"]) {

        case 'guardaryeditar':

          // imgen de perfil
          if (!file_exists($_FILES['foto1']['tmp_name']) || !is_uploaded_file($_FILES['foto1']['tmp_name'])) {

						$imagen1=$_POST["foto1_actual"]; $flat_img1 = false;

					} else {

						$ext1 = explode(".", $_FILES["foto1"]["name"]); $flat_img1 = true;						

            $imagen1 = $date_now .' '. rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext1);

            move_uploaded_file($_FILES["foto1"]["tmp_name"], "../dist/docs/all_trabajador/perfil/" . $imagen1);
						
					}

          // cv documentado
          if (!file_exists($_FILES['doc4']['tmp_name']) || !is_uploaded_file($_FILES['doc4']['tmp_name'])) {

            $cv_documentado=$_POST["doc_old_4"]; $flat_cv1 = false;

          } else {

            $ext3 = explode(".", $_FILES["doc4"]["name"]); $flat_cv1 = true;
            
            $cv_documentado = $date_now .' '. rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext3);

            move_uploaded_file($_FILES["doc4"]["tmp_name"], "../dist/docs/all_trabajador/cv_documentado/" .  $cv_documentado);
            
          }         

          if (empty($idtrabajador)){
            
            $rspta=$trabajador->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, format_a_m_d($nacimiento), 
            $edad,  $email, $banco_seleccionado, $banco, $cta_bancaria, $cci, $titular_cuenta, $tipo, $_POST["desempenio"], $ocupacion, $ruc, $imagen1, $imagen2, $imagen3, $cv_documentado, $cv_nodocumentado);
            
            echo json_encode($rspta, true);
  
          }else {

            // validamos si existe LA IMG para eliminarlo
            if ($flat_img1 == true) {
              $datos_f1 = $trabajador->obtenerImg($idtrabajador);
              $img1_ant = $datos_f1['data']['imagen_perfil'];
              if ($img1_ant != "") { unlink("../dist/docs/all_trabajador/perfil/" . $img1_ant);  }
            }

            //imagen_dni_anverso
            if ($flat_img2 == true) {
              $datos_f2 = $trabajador->obtenerImg($idtrabajador);
              $img2_ant = $datos_f2['data']['imagen_dni_anverso'];
              if ($img2_ant != "") { unlink("../dist/docs/all_trabajador/dni_anverso/" . $img2_ant); }
            }

            //imagen_dni_reverso
            if ($flat_img3 == true) {
              $datos_f3 = $trabajador->obtenerImg($idtrabajador);
              $img3_ant = $datos_f3['data']['imagen_dni_reverso'];
              if ($img3_ant != "") { unlink("../dist/docs/all_trabajador/dni_reverso/" . $img3_ant); }
            }

            //cvs
            if ($flat_cv1 == true) {
              $datos_cv1 = $trabajador->obtenercv($idtrabajador);
              $cv1_ant = $datos_cv1['data']['cv_documentado'];
              if ($cv1_ant != "") { unlink("../dist/docs/all_trabajador/cv_documentado/" . $cv1_ant); }
            }

            if ($flat_cv2 == true) {
              $datos_cv2 = $trabajador->obtenercv($idtrabajador);
              $cv2_ant = $datos_cv2['data']['cv_no_documentado'];
              if ($cv2_ant != "") { unlink("../dist/docs/all_trabajador/cv_no_documentado/" . $cv2_ant); }
            }

            // editamos un trabajador existente
            $rspta=$conyuge->editar($idtrabajador, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, format_a_m_d( $nacimiento), 
            $edad, $email, $banco_seleccionado, $banco, $cta_bancaria, $cci,  $titular_cuenta, $tipo, $_POST["desempenio"], $ocupacion, $ruc, $imagen1, $imagen2, $imagen3, $cv_documentado, $cv_nodocumentado);
            
            echo json_encode($rspta, true);
          }            

        break;

        case 'mostrar':

          $rspta=$conyuge->mostrar($idtrabajador);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);

        break;

        case 'tbla_principal':          

          $rspta=$conyuge->tbla_principal(1);
          
          //Vamos a declarar un array
          $data= Array(); $cont=1;

          if ($rspta['status'] == true) {

            foreach ($rspta['data'] as $key => $value) {             
              $imagen = (empty($value['imagen_perfil']) ? '../dist/svg/user_default.svg' : '../dist/docs/all_trabajador/perfil/'. $value['imagen_perfil']) ;
          
              $data[]=array(
                "0"=>$cont++,
                "1"=>($value['estado'])?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$value['idtrabajador'].')" data-toggle="tooltip" data-original-title="Editar"><i class="fas fa-pencil-alt"></i></button>'.
                  ' <button class="btn btn-danger btn-sm" onclick="eliminar('.$value['idtrabajador'].', \''.encodeCadenaHtml($value['trabajador']).'\')" data-toggle="tooltip" data-original-title="Eliminar o papelera"><i class="fas fa-skull-crossbones"></i></button>'.
                  ' <button class="btn btn-info btn-sm" onclick="verdatos('.$value['idtrabajador'].')"data-toggle="tooltip" data-original-title="ver datos"><i class="far fa-eye"></i></button>':
                  ' <button class="btn btn-info btn-sm" onclick="verdatos('.$value['idtrabajador'].')" data-toggle="tooltip" data-original-title="Ver datos"><i class="far fa-eye"></i></button>',
                "2"=>'<div class="user-block">
                  <img class="img-circle cursor-pointer" src="../dist/docs/all_trabajador/perfil/'. $value['imagen_perfil'] .'" alt="User Image" onerror="'.$imagen_error.'" onclick="ver_perfil(\'' . $imagen . '\', \''.encodeCadenaHtml($value['trabajador']).'\');" data-toggle="tooltip" data-original-title="Ver imagen">
                  <span class="username"><p class="text-primary m-b-02rem" >'. $value['trabajador'] .'</p></span>
                  <span class="description">'. $value['tipo_documento'] .': '. $value['numero_documento'] .' </span>
                  </div>',
                "3"=> $value['nombre_tipo'],
                "4"=> $value['nombre_ocupacion'],
                "5"=> '<div class="bg-color-242244245 " style="overflow: auto; resize: vertical; height: 45px;" >'.$value['html_desempenio'].'</div>',
                "6"=>'<a href="tel:+51'.quitar_guion($value['telefono']).'" data-toggle="tooltip" data-original-title="Llamar al trabajador.">'. $value['telefono'] . '</a>',
                "7"=>format_d_m_a($value['fecha_nacimiento']).'<b>: </b>'. '<b>'.$value['edad'].'</b>' ,
                "8"=> '<b>'.$value['banco'] .': </b>'. $value['cuenta_bancaria'] .' <br> <b>CCI: </b>'.$value['cci'],

                "9"=>(($value['estado'])?'<span class="text-center badge badge-success">Activado</span>': '<span class="text-center badge badge-danger">Desactivado</span>').$toltip,
                "10"=> $value['trabajador'],
                "11"=> $value['tipo_documento'],
                "12"=> $value['numero_documento'],
                "13"=> format_d_m_a($value['fecha_nacimiento']),
                "14"=>$value['edad'],
                "15"=> $value['banco'],
                "16"=> $value['cuenta_bancaria'],
                "17"=> $value['cci'],
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
        
        case 'verdatos':
          $rspta=$conyuge->verdatos($idtrabajador);
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